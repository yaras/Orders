<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\BadRequestException;


class TestsController extends AppController
{
  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    $this->Auth->allow('index');

    if (!Configure::read('debug')) {
      throw new BadRequestException();
    }
  }

  public function index() {
    $this->viewBuilder()->layout(false);
  }

}
