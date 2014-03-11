<?php

App::uses( 'File', 'Utility' );
class Factory extends Object
{

  /**
   * the name of the model to be initialized
   *
   * @var integer
   */
  protected $name;


  /**
   * the instance for the factories to work
   *
   * @var Model
   */
  protected $model;

  /**
   * Initialize everything!
   *
   * @param string $name
   */
  public function __construct( $name )
  {
    $this->name  = ucfirst( $name );
    $this->model = ClassRegistry::init( $name );

    $this->model->useDbConfig = 'test';
  }


  /**
   * Return the model name to be used
   *
   * @return string
   */
  function getName()
  {
    return $this->name;
  }

  /**
   * return the model
   *
   * @return Model
   */
  function getModel()
  {
    return $this->model;
  }

}
