<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Message extends Entity {

  protected $_accessible = [
      '*' => true,
      'id' => false
  ];
}
