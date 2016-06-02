<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

use App\Model\Entity\Order;

class MessagesController extends AppController
{
  public function initialize()
  {
      parent::initialize();
      $this->loadComponent('RequestHandler');
  }

  public function all($id)
  {
    $messages = $this->Messages->find('all', [
      'conditions' => [ 'order_id' => $id ],
      'order' => 'Messages.id desc',
      'contain' => ['Users' => function($q) {
        return $q->select(['name']);
      }]
    ]);

    $this->set('messages', $messages);
    $this->set('_serialize', ['messages']);
  }

  public function add()
  {
    if ($this->request->is('post'))
    {
      $msg = $this->Messages->newEntity();

      $data = $this->request->data;
      $this->Messages->patchEntity($msg, $data);

      $additionalData = [
        'created' => date("Y-m-d H:i:s"),
        'author_user_id' => $this->Auth->user()['id']
      ];

      $data = array_merge($data, $additionalData);
      $this->Messages->patchEntity($msg, $additionalData);

      $result = $this->Messages->save($msg);

      $orders = TableRegistry::get('Orders');
      $order = $orders->get($data['order_id']);

      $this->sendNotifications(
        $data['order_id'],
        'Added a message',
        sprintf('"%s" wrote "%s" on "%s"', $this->Auth->user()['name'], $data['message'], $order['title']),
        false,
        true);

      $this->sendSilentNotificationsToAll($data['order_id']);

      if ($result) {
        $data = array_merge($data, [ 'id' => $result->id, 'Author' => [ 'name' => $this->Auth->user()['name'] ] ]);

        $this->set('status', 'success');
        $this->set('data', $data);
      } else {
        $this->set('status', 'error');
      }
    }

    $this->set('_serialize', ['status', 'data']);
  }
}
