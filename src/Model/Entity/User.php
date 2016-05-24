<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;

class User extends Entity {

  protected $_accessible = [
      '*' => true,
      'id' => false
  ];

  protected function _setPassword($password)
  {
    return (new DefaultPasswordHasher)->hash($password);
  }
}
