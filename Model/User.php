<?php

App::uses( 'AppModel', 'Model' );
class User extends AppModel
{

  public $validate = array(
    'username' => array(
      'rule' => 'notEmpty'
    )
  );

}
