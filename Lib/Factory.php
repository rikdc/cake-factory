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
   * The major data list that can be overridden
   *
   * @var array
   */
  protected $data = array();

  /**
   * Initialize everything!
   *
   * @param string $name
   */
  public function __construct( $name, $attributes = array() )
  {
    $this->attributes = $attributes;

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
   * @return null
   */
  private function validateFile()
  {
    if(!file_exists( $this->file ))
      throw new \Exception( "File: {$this->file} does not exist" );
  }

  /**
   * Model configuration
   *
   * @return null
   */
  private function configureModel()
  {
    // initialize the model
    $this->model = ClassRegistry::init( $this->name );

    // use the test database
    $this->model->useDbConfig = 'test';
  }



  /**
   * parse the JSON file and store it inside the attributes
   *
   * @return Factory
   */
  function parse()
  {
    $file = new File( $this->file );

    // read the contents
    $content = $file->read();

    // convert the file into an array
    $this->data = json_decode( $content, true );
    return $this;
  }


  /**
   * builds
   */
  function build()
  {
    $this->model->set( [ 'username' => 'hello' ] );
    echo print_r( $this->model->data, true );

    return $this->model;
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

  /**
   * return the model data
   *
   * @return array
   */
  function getData()
  {
    return $this->data;
  }

}
