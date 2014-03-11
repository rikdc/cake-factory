<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'bootstrap.php';

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

  function its_parse_should_return_itself()
  {
    $this->parse()->shouldReturnAnInstanceOf( 'Factory' );
  }


  function it_parses_the_json_file_and_sets_it()
  {
    $this->parse()->getData()->shouldBeEqualTo(array(
      'username' => 'factory.username',
      'password' => 'factory.password',
      'email'    => 'emailaddress@aeolu.com'
    ));
  }

  function its_build_should_return_itself()
  {
    $this->build()->shouldReturnAnInstanceOf( 'Model' );
  }

  function its_attributes_are_overridden_with_set_attributes()
  {
    // $attributes = array( 'username' => 'another.username' );
  }


}
