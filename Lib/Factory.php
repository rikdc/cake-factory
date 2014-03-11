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
   * JSON file to be parsed
   *
   * @var string
   */
  protected $file;

  /**
   * Initialize everything!
   *
   * @param string $name
   */
  public function __construct( $name )
  {
    $this->name  = ucfirst( $name );
    $this->file  = FACTORY . DS . "{$this->name}.json";

    // validate the file's existence
    $this->validateFile();

    // configure the model
    $this->configureModel();

  }


  /**
   * Check to see if the file exists..
   *  or throw a tantru.. i mean error.
   *
   */
  private function validateFile()
  {
    if(!file_exists( $this->file ))
      throw new \Exception( "File: {$this->file} does not exist" );
  }

  /**
   * Model configuration
   *
   */
  private function configureModel()
  {
    // initialize the model
    $this->model = ClassRegistry::init( $this->name );

    // use the test database
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

  /**
   * return the json file
   *
   * @return string
   */
  function getFile()
  {
    return $this->file;
  }

}
