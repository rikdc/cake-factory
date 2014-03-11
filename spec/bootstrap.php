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
