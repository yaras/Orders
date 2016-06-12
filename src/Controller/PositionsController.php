<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

use App\Model\Entity\Order;

class PositionsController extends AppController
{
  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('RequestHandler');
  }

  public function all($id)
  {
    $positions = $this->Positions->find('all', [
      'conditions' => [ 'order_id' => $id ],
      'order' => 'Positions.meal',
      'contain' => ['Users' => function($q) {
        return $q->select(['name']);
      }]
    ]);

    $currentUserId = $this->Auth->user()['id'];

    foreach ($positions as $p)
    {
      $p['permission'] = $p['user_id'] == $currentUserId;
    }

    $this->set('positions', $positions);
    $this->set('_serialize', ['positions']);
  }

  public function add()
  {
    if ($this->request->is('post'))
    {
      $pos = $this->Positions->newEntity();

      $data = $this->request->data;
      $this->Positions->patchEntity($pos, $data);

      $additionalData = [
        'user_id' => $this->Auth->user()['id']
      ];

      $data = array_merge($data, $additionalData);
      $this->Positions->patchEntity($pos, $additionalData);

      $result = $this->Positions->save($pos);

      $orders = TableRegistry::get('Orders');
      $order = $orders->get($data['order_id']);

      $this->sendNotifications(
        $data['order_id'],
        'Added position',
        sprintf('"%s" added position "%s" to "%s"', $this->Auth->user()['name'], $data['meal'], $order['title']),
        false,
        true);

      $this->sendSilentNotificationsToAll($data['order_id']);

      if ($result) {
        $data = array_merge($data, [ 'id' => $result->id, 'User' => [ 'name' => $this->Auth->user()['name'] ] ]);

        $this->set('status', 'success');
        $this->set('data', $data);
      } else {
        $this->set('status', 'error');
      }
    }

    $this->set('_serialize', ['status', 'data']);
  }

  public function delete($id)
  {
    if ($this->request->is('post'))
    {
      $pos = $this->Positions->get($id);
      $result = $this->Positions->delete($pos);

      $orders = TableRegistry::get('Orders');
      $order = $orders->get($pos['order_id']);

      $this->sendNotifications(
        $pos['order_id'],
        'Deleted position',
        sprintf('"%s" deleted "%s" from "%s"', $this->Auth->user()['name'], $pos['meal'], $order['title']),
        false,
        true);

      $this->sendSilentNotificationsToAll($pos['order_id']);

      if ($result) {
        $this->set('status', 'success');
      } else {
        $this->set('status', 'error');
      }
    }

    $this->set('_serialize', ['status']);
  }

  public function setStatus($id) {
    if ($this->request->is('post'))
    {
      $position = $this->Positions->get($id, [
        'contain' => ['Users' => function($q) {
          return $q->select(['name']);
      }]]);

      $this->Positions->patchEntity($position, $this->request->data(), [
        'fieldList' => ['paid']
      ]);

      $result = $this->Positions->save($position);

      $this->sendNotifications($position['order_id'],
        'Changed position paid status',
        sprintf(
          '"%s" changed status of "%s" (%s) to "%s"',
          $this->Auth->user()['name'],
          $position['meal'],
          $position['Author']['name'],
          $position['paid'] == 1 ? 'paid' : 'not paid'),
        false,
        true);

      $this->sendSilentNotificationsToAll($position['order_id']);

      if ($result)
      {
        $this->set('status', 'success');
      } else {
        $this->set('status', 'error');
      }
    }

    $this->set('_serialize', ['status']);
  }

  public function edit($id)
  {
    if ($this->request->is('post'))
    {
      $position = $this->Positions->get($id, [
        'contain' => ['Users' => function($q) {
          return $q->select(['name']);
      }]]);

      $this->Positions->patchEntity($position, $this->request->data, [
        'fieldList' => ['meal', 'cost']
      ]);

      $result = $this->Positions->save($position);

      $orders = TableRegistry::get('Orders');
      $order = $orders->get($position['order_id']);

      $this->sendNotifications(
        $position['order_id'],
        'Changed position',
        sprintf('"%s" changed position "%s" ("%s") on "%s"',
          $this->Auth->user()['name'],
          $position['meal'],
          $position['Author']['name'],
          $order['title']),
        false,
        true);

      $this->sendSilentNotificationsToAll($position['order_id']);

      if ($result)
      {
        $this->set('status', 'success');
      }
      else
      {
        $this->set('status', 'error');
      }
    }

    $this->set('_serialize', ['status']);
  }
}
