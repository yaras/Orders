<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Log\Log;

use App\Model\Entity\User;

class UsersController extends AppController
{
  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    $this->Auth->allow('add');
  }

  public function add() {
    $user = $this->Users->newEntity();

    if ($this->request->is('post')) {
      $user = $this->Users->patchEntity($user, $this->request->data);

      if ($this->Users->save($user)) {
        $this->Flash->success(__('Account created'));
        return $this->redirect(['action' => 'login']);
      }

      $this->set('errors', $user->errors());
      $this->Flash->error(__('Unable to create account'));
    }

    $this->set('user', $user);
  }

  public function login() {
    $user = $this->Users->newEntity();

    if ($this->request->is('post'))
    {
      $user = $this->Auth->identify();

      if ($user)
      {
        $this->Auth->setUser($user);

        if (isset($this->request->data['remember_me']) && $this->request->data['remember_me'] == 'on') {

          $cookie = [ $this->request->data['name'], $this->request->data['password'] ];
          $this->Cookie->write('remember_me_cookie', $cookie, true, '2 weeks');
        }

        return $this->redirect('/');
      }
      else
      {
        $this->Flash->error(__('Username or password is incorrect'), ['key' => 'auth']);
        $this->set('authError', true);
      }
    }
    else
    {
      if ($this->Auth->user() != null)
      {
        return $this->redirect('/');
      }
    }

    $this->set('user', $user);
  }

  public function logout()
  {
    // clear the cookie (if it exists) when logging out
    $this->Cookie->delete('remember_me_cookie');

    return $this->redirect($this->Auth->logout());
  }
}
