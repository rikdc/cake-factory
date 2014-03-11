<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

define( 'ROOT', dirname(dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'FACTORY', ROOT . DS . 'Factory' );

// load the CakePHP global methods to not fuck things up
include_once ROOT . DS . 'vendor' . DS . 'pear-pear.cakephp.org' . DS . 'CakePHP' . DS . 'Cake' . DS . 'basics.php';

class FactorySpec extends ObjectBehavior
{

  function let()
  {
    $this->beConstructedWith( 'user' );
  }

  function it_is_initializable()
  {
    $this->shouldHaveType('Factory');
  }

  function it_can_return_the_model_name_to_be_parsed()
  {
    $this->getName()->shouldBe( 'User' );
  }

  function it_initializes_a_model()
  {
    $this->getModel()->shouldReturnAnInstanceOf( 'Model' );
  }

  function its_model_database_settings_should_be_set_to_test()
  {
    $this->getModel()->useDbConfig->shouldBeEqualTo( 'test' );
  }

  function it_can_return_the_name_of_the_json_file_to_be_parsed()
  {
    $expected = FACTORY . DS . 'User.json';
    $this->getFile()->shouldBeEqualTo( $expected );
  }

  function it_checks_if_the_file_to_be_parsed_exists()
  {
    $file = FACTORY . DS . 'Model.json';
    $this->shouldThrow( new \Exception( "File: {$file} does not exist" ) )->during( '__construct', [ 'model' ] );
  }

  function it_can_return_an_attribute_override_list()
  {
    $attributes = array(
      'username' => 'another.username'
    );

    $this->setAttributes( $attributes );
    $this->getAttributes()->shouldBeEqualTo( $attributes );
  }

}
