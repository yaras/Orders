<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

use App\Model\Entity\Order;

class OrdersController extends AppController
{
  public function initialize()
  {
      parent::initialize();
      $this->loadComponent('RequestHandler');
  }

  public function index()
  {
  }

  public function all()
  {
    $orders = $this->Orders->find('all', [
      'conditions' => [ 'archived' => 0 ],
      'order' => 'Orders.id desc',
      'contain' => ['Users' => function($q) {
        return $q->select(['name']);
      }]
    ]);

    $ordersArray = $orders->toArray();

    $sums = $this->getCost(NULL);
    $paid = $this->getPaid(NULL);

    foreach($ordersArray as $o) {
      if (array_key_exists($o['id'], $sums))
      {
        $o['cost'] = $sums[$o['id']];
      }
      else
      {
        $o['cost'] = 0;
      }

      if (array_key_exists($o['id'], $paid))
      {
        $o['paid'] = $paid[$o['id']];
        $o['progress'] = 100 * $paid[$o['id']] / $sums[$o['id']];
      }
      else {
        $o['paid'] = 0;
        $o['progress'] = 0;
      }
    }

    $this->set('orders', $ordersArray);
    $this->set('_serialize', ['orders']);
  }

  public function get($id)
  {
    $order = $this->Orders->get($id, [
      'contain' => ['Users' => function($q) {
        return $q->select(['name']);
      }]
    ]);

    $sums = $this->getCost($id);
    $paid = $this->getPaid($id);

    if (array_key_exists($id, $sums))
    {
      $order['cost'] = $sums[$id];
    }
    else
    {
      $order['cost'] = 0;
    }

    if (array_key_exists($id, $paid))
    {
      $order['paid'] = $paid[$id];
      $order['progress'] = 100 * $paid[$id] / $sums[$id];
    }
    else {
      $order['paid'] = 0;
      $order['progress'] = 0;
    }

    $this->set('order', $order);
    $this->set('_serialize', ['order']);
  }

  public function add()
  {
    if ($this->request->is('post'))
    {
      $order = $this->Orders->newEntity();

      $data = $this->request->data;
      $this->Orders->patchEntity($order, $data);

      $additionalData = [
        'created' => date("Y-m-d H:i:s"),
        'author_user_id' => $this->Auth->user()['id'],
        'status' => 'New'
      ];

      $data = array_merge($data, $additionalData);
      $this->Orders->patchEntity($order, $additionalData);

      $result = $this->Orders->save($order);

      $this->sendNotificationsToAll(
        'Added new order',
        sprintf('"%s" added new order: "%s"', $this->Auth->user()['name'], $order['title']),
        true
      );

      if ($result) {
        $data = array_merge($data, [
          'id' => $result->id,
          'Author' => ['name' => $this->Auth->user()['name'] ],
          'cost' => 0,
          'paid' => 0
        ]);

        $this->set('status', 'success');
        $this->set('data', $data);
      } else {
        $this->set('status', 'error');
      }
    }

    $this->set('_serialize', ['status', 'data']);
  }

  public function edit($id)
  {
    if ($this->request->is('post'))
    {
      $order = $this->Orders->get($id);

      $this->Orders->patchEntity($order, $this->request->data, [
        'fieldList' => ['title', 'description', 'order_time']
      ]);

      $result = $this->Orders->save($order);

      $this->sendNotifications(
        $id,
        'Order modified',
        sprintf('Order "%s" was modified by "%s"', $order['title'], $this->Auth->user()['name']),
        false,
        true);

      $this->set('status', 'success');
      $this->set('result', $result);
    }

    $this->set('_serialize', ['status', 'result']);
  }

  public function delete($id)
  {
    if ($this->request->is('post'))
    {
      $order = $this->Orders->get($id);

      $this->sendNotifications(
        $id,
        'Order deleted',
        sprintf('Order "%s" was deleted by "%s"', $order['title'], $this->Auth->user()['name']),
        true,
        false);

      $result = $this->Orders->delete($order);

      $this->set('result', $result);
    }

    $this->set('_serialize', ['result']);
  }

  public function setArchived($id)
  {
    if ($this->request->is('post'))
    {
      $order = $this->Orders->get($id);

      $this->Orders->patchEntity($order, ['archived' => 1]);

      $result = $this->Orders->save($order);

      $this->sendNotifications(
        $id,
        'Order archived',
        sprintf('Order "%s" is archived', $order['title']),
        true,
        false);

      $this->set('status', 'success');
      $this->set('result', $result);
    }

    $this->set('_serialize', ['status', 'result']);
  }

  public function setStatus($id)
  {
    if ($this->request->is('post'))
    {
      $order = $this->Orders->get($id);

      $this->Orders->patchEntity($order, $this->request->data(), [
        'fieldList' => ['status']
      ]);

      $result = $this->Orders->save($order);

      $this->sendNotifications(
        $id,
        'Order changed status',
        sprintf('Order "%s" changed status to %s', $order['title'], $order['status']),
        false,
        true);

      $this->set('status', 'success');
      $this->set('result', $result);
    }

    $this->set('_serialize', ['status', 'result']);
  }

  private function getCost($id)
  {
    $positions = TableRegistry::get('Positions');

    $conditions = [];

    if ($id != NULL) {
      $conditions['Orders.id'] =  $id;
    }

    $conditions['Orders.archived'] = 0;

    $result = $positions->find('all', [
      'conditions' => $conditions,
      'contain' => ['Orders']
    ]);

    $result->select(['order_id', 'sum'=>'sum(cost)'])->group('order_id');

    $sums = [];

    foreach($result as $sum) {
      $sums[$sum['order_id']] = $sum['sum'];
    }

    return $sums;
  }

  private function getPaid($id)
  {
    $positions = TableRegistry::get('Positions');

    $conditions = [];

    if ($id != null)
    {
      $conditions['Orders.id'] = $id;
    }

    $conditions['Orders.archived'] = 0;
    $conditions['paid'] = 1;

    $result = $positions->find('all', [
      'conditions' => $conditions,
      'contain' => ['Orders']
    ]);

    $result->select(['order_id', 'sum'=>'sum(cost)'])->group('order_id');

    $sums = [];

    foreach($result as $sum) {
      $sums[$sum['order_id']] = $sum['sum'];
    }

    return $sums;
  }
}
