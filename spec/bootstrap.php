<?php

/**
 * Shortened directory separator
 */
define( 'DS', DIRECTORY_SEPARATOR );

/**
 * Application root
 */
define( 'APP', dirname(dirname(__FILE__)) . DS );

/**
 * Factory location
 */
define( 'FACTORY', APP . 'Factory' );


define( 'CAKE', APP . 'vendor' . DS . 'pear-pear.cakephp.org' . DS . 'CakePHP' . DS . 'Cake' );


// load the CakePHP global methods to not fuck things up
require_once CAKE . DS . 'basics.php';


/**
 * Create the test database
 *
 */
function createDatabase()
{
  $config   = APP . 'Config';
  $database = $config . DS . 'factory.db';
  $schema   = $config . DS . 'schema.sql';

  $command = "sqlite3 {$database} < {$schema}";
  system( $command );
}


/**
 * Delete the database
 *
 */
function deleteDatabase()
{
  $database = APP . 'Config' . DS .'factory.db';
  $command  = "rm {$database}";

  system( $command );
}
