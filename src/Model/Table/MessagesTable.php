<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MessagesTable extends Table
{
  public function initialize(array $config)
  {
    $this->belongsTo('Users', [
      'foreignKey' => 'author_user_id',
      'propertyName' => 'Author'
    ]);
  }
}
