<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use App\Model\Entity\Order;

class NotificationsController extends AppController
{
  public function initialize()
  {
      parent::initialize();
      $this->loadComponent('RequestHandler');
  }

  public function all()
  {
    $notifications = $this->Notifications->find('all', [
      'conditions' => [ 'user_id' => $this->Auth->user()['id'], 'downloaded' => 0 ],
      'order' => 'Notifications.id asc']);

    $result = $notifications->toArray();

    foreach($result as $n)
    {
      $not = $this->Notifications->get($n['id']);
      $this->Notifications->patchEntity($not, ['downloaded' => 1]);
      $res = $this->Notifications->save($not);
    }

    $this->set('notifications', $result);
    $this->set('_serialize', ['notifications']);
  }

  public function dismiss()
  {
    if ($this->request->is('post'))
    {
      $this->Notifications->updateAll(
        [ 'downloaded' => 1 ],
        [ 'user_id' => $this->Auth->user()['id'] ]
      );

      $this->set('status', 'success');
    } else {
      $this->set('status', 'error');
    }

    $this->set('_serialize', ['status']);
  }
}
