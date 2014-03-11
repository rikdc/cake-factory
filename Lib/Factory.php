<?php

App::uses( 'File', 'Utility' );
class Factory extends Object
{

  /**
   * the marker for the incremental operator
   *
   * @var string
   */
  const INCREMENT_OPERATOR = '#{n}';


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
   * Counter listing for the factory increments
   *
   * @var array
   */
  protected $counters = array();




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
   * lookup the counters, set and increment
   *
   * @return null
   */
  private function lookupCounters()
  {
    foreach( $this->data as $field => $value )
    {

      // skip if the field has no '#{n}'
      if( !strstr( $value, self::INCREMENT_OPERATOR ) )
        continue;

      // set the counter
      if( !array_key_exists( $field, $this->counters ) )
        $this->counters[ $field ] = 1;

      // replace the field with the countered operator
      $this->data[ $field ] = str_replace( self::INCREMENT_OPERATOR, $this->counters[ $field ]++, $value );
    }
  }



  /**
   * parse the JSON file and store it inside the attributes r
   *
   * @return null
   */
  function parse()
  {
    $file = new File( $this->file );

    // read the contents
    $content = $file->read();

    // convert the file into an array
    $this->data = json_decode( $content, true );

  }


  /**
   * builds the model object
   *
   * @param  array   $attributes override the default attributes
   * @return Model
   */
  function build( $attributes = array() )
  {
    $this->parse();

    // override the attributes
    $this->data = array_merge( $this->data, $attributes );
    $this->lookupCounters();

    // make sure this resets the model
    $this->model->create();

    // set the fields
    $this->model->set( $this->data );

    return $this->model;
  }


  /**
   * return the validity of the model data
   *
   * @param  array     $attributes
   * @return boolean
   */
  function validates( $attributes = array() )
  {
    return $this->build( $attributes )->validates();
  }


  /**
   * Bypass the validations and save to the database
   *
   * @param  array   $attributes
   * @return Model
   */
  function create( $attributes = array() )
  {
    $this->build( $attributes )->save( null, false );
    return $this->model;
  }


  /**
   * Repeats create() for database population
   *
   * @param  array   $attributes
   * @return null
   */
  function populate( $count = 5, $attributes = array() )
  {
    for( $i = 0; $i < $count; $i++ )
      $this->build( $attributes )->save( null, false );
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
