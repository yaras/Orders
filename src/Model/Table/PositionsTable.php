<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PositionsTable extends Table
{
  public function initialize(array $config)
  {
    $this->belongsTo('Users', [
       'foreignKey' => 'user_id',
       'propertyName' => 'Author'
     ]);

     $this->belongsTo('Orders', [
        'foreignKey' => 'order_id',
        'propertyName' => 'Order'
      ]);
  }
}
