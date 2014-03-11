<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

define( 'ROOT', dirname(dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );

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

}
