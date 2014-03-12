<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \PDO;

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'bootstrap.php';

class FactorySpec extends ObjectBehavior
{

  function let()
  {
    createDatabase();
    $this->beConstructedWith( 'user' );
  }

  function letgo()
  {
    deleteDatabase();
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

  function it_parses_the_json_file_and_sets_it()
  {
    $this->parse();
    $this->getData()->shouldBeEqualTo(array(
      'username' => 'factory.username',
      'password' => 'factory.password',
      'email'    => 'emailaddress@aeolu.com',
      "role_id"  => array(
        "model"       => "Role",
        "attributes"  => array(
          "name"  => "Member"
        )
      )
    ));
  }

  function its_build_returns_an_instance_of_model()
  {
    $this->build()->shouldReturnAnInstanceOf( 'Model' );
  }

  function it_builds_the_model_with_the_json_data()
  {
    $attributes = array( 'role_id' => null );
    $this->build( $attributes )->data->shouldBeEqualTo(array(
      'User' => array(
        'username' => 'factory.username',
        'password' => 'factory.password',
        'email'    => 'emailaddress@aeolu.com',
        "role_id"  => null
      )
    ));
  }

  function its_attributes_are_overridden_with_set_attributes()
  {
    $attributes = array(
      'username' => 'another.username',
      'role_id'  => null
    );

    $this->build( $attributes )->data->shouldBeEqualTo(array(
      'User' => array(
        'username' => 'another.username',
        'password' => 'factory.password',
        'email'    => 'emailaddress@aeolu.com',
        'role_id'  => null
      )
    ));
  }

  function it_returns_the_validity_of_the_data_set()
  {
    $attributes = array( 'username' => 'another.username' );

    $this->validates( $attributes )->shouldBeEqualTo( true );
  }


  function it_should_see_the_example_model_validation_rules()
  {
    $attributes = array( 'username' => null );

    $this->validates( $attributes )->shouldBeEqualTo( false );
  }

  function it_bypasses_validation_on_creating_factories()
  {
    $attributes = array( 'username' => null );

    $this->create( $attributes )->validationErrors->shouldBeEqualTo( array() );
  }

  function it_has_incremental_counters_to_avoid_duplicate_population()
  {
    $attributes[ 'username' ] = 'username#{n}';

    $this->build( $attributes )->data[ 'User' ][ 'username' ]->shouldBe( 'username1' );
  }

  function it_can_associate_models_on_the_fly()
  {
    $this->create()->field( 'role_id' )->shouldBeLike( 6 );
  }


}
