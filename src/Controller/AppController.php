<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;

define("APP_VERSION", "0.1.0");

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  /**
   * Initialization hook method.
   *
   * Use this method to add common initialization code like loading components.
   *
   * e.g. `$this->loadComponent('Security');`
   *
   * @return void
   */
  public function initialize()
  {
      parent::initialize();

      $this->loadComponent('RequestHandler');
      $this->loadComponent('Flash');
      $this->loadComponent('Cookie');

      $this->loadComponent('Auth', [
        'loginAction' => [
            'controller' => 'Users',
            'action' => 'login'
        ],
        'authenticate' => [
            'Form' => [
                'fields' => ['username' => 'name']
            ]
        ],
        'storage' => 'Session'
    ]);
  }

  public function beforeFilter(Event $event)
  {
    $this->Cookie->key = Configure::read('Security.key');
    $this->Cookie->httpOnly = true;

    $cookie = $this->Cookie->read('remember_me_cookie');

    if ($this->Auth->user() == null && $cookie != null) {
      $users = TableRegistry::get('Users');

      $query = $users->find('all', array(
        'conditions' => array(
            'name' => $cookie[0]
        )
      ));

      $user = $query->first();

      if ($user != null && !(new DefaultPasswordHasher)->check($cookie[1], $user['password']))
      {
        $user = null;
      }

      if ($user == null)
      {
        $this->Cookie->delete('remember_me_cookie');
        $this->redirect('/users/logout');
      }
      else
      {
        $this->Auth->setUser([
          'id' => $user['id'],
          'name' => $user['name']
        ]);

        return $this->redirect('/');
      }
    }
  }

  public function beforeRender(Event $event)
  {
    $this->set('version', APP_VERSION);
    $this->set('authUser', $this->Auth->user());

    if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml']))
    {
      $this->set('_serialize', true);
    }
  }

  protected function sendNotifications($orderId, $title, $message, $reloadOrders, $reloadOrder)
  {
    $this->clearOverdueNotifications();

    $orders = TableRegistry::get('Orders');
    $notifications = TableRegistry::get('Notifications');
    $positions = TableRegistry::get('Positions');

    $order = $orders->get($orderId);
    $query = $positions->find();

    $currentUserId = $this->Auth->user()['id'];

    $query
      ->where(['order_id' => $orderId])
      ->distinct(['user_id']);

    $usersToSend = [];

    foreach ($query as $position)
    {
      if ($position['user_id'] == $currentUserId) {
        continue;
      }

      if (in_array($position['user_id'], $usersToSend))
      {
        continue;
      }

      $usersToSend[] = $position['user_id'];

      $not = $notifications->newEntity();

      $notifications->patchEntity($not, [
        'user_id' => $position['user_id'],
        'order_id' => $orderId,
        'title' => $title,
        'message' => $message,
        'reload_orders' => $reloadOrders ? 1 : 0,
        'reload_order' => $reloadOrder ? 1 : 0
      ]);

      $notifications->save($not);
    }

    if (!in_array($order['author_user_id'], $usersToSend) && $order['author_user_id'] != $currentUserId)
    {
      $not = $notifications->newEntity();

      $notifications->patchEntity($not, [
        'user_id' => $order['author_user_id'],
        'order_id' => $orderId,
        'title' => $title,
        'message' => $message,
        'reload_orders' => $reloadOrders ? 1 : 0,
        'reload_order' => $reloadOrder ? 1 : 0,
        'reload_positions' => $reloadPositions ? 1 : 0,
        'reload_messages' => $reloadMessages ? 1 : 0
      ]);

      $notifications->save($not);
    }
  }

  protected function sendNotificationsToAll($title, $message, $reloadOrders)
  {
    $this->clearOverdueNotifications();

    $users = TableRegistry::get('Users');
    $notifications = TableRegistry::get('Notifications');

    $currentUserId = $this->Auth->user()['id'];

    $query = $users->find('all');

    foreach ($query as $user) {
      if ($user['id'] == $currentUserId) {
        continue;
      }

      $not = $notifications->newEntity();

      $notifications->patchEntity($not, [
        'user_id' => $user['id'],
        'title' => $title,
        'message' => $message,
        'reload_orders' => $reloadOrders ? 1 : 0,
        'reload_order' => 0
      ]);

      $notifications->save($not);
    }
  }

  private function clearOverdueNotifications()
  {
    $notifications = TableRegistry::get('Notifications');

    $notifications->deleteAll([
      'created < ' => date("Y-m-d H:i:s", strtotime("-3 days"))
    ]);
  }
}
