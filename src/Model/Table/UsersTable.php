<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
  public function validationDefault(Validator $validator)
  {
    $validator->notEmpty('name');
    $validator->notEmpty('password');
    $validator->notEmpty('password-repeat');

    $validator->add('password-repeat',
      'compareWith', [
        'rule' => ['compareWith', 'password'],
        'message' => 'Passwords not equal.'
    ]);

    $validator->add('name', 'unique', [
      'rule' => 'validateUnique',
      'provider' => 'table',
      'message' => 'Such user already exists'
    ]);

    return $validator;
  }
}
