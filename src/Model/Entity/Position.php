<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Position extends Entity {

  protected $_accessible = [
      '*' => true,
      'id' => false
  ];
}
