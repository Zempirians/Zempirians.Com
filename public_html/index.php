<?php
// public/index.php
//
// Step 1: APPLICATION_PATH is a constant pointing to our
// application/subdirectory. We use this to add our "library" directory
// to the include_path, so that PHP can find our Zend Framework classes.
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application/'));
set_include_path(
    APPLICATION_PATH . '/../library' 
    . PATH_SEPARATOR . get_include_path()
);

// Step 2: AUTOLOADER - Set up autoloading.
// This is a nifty trick that allows ZF to load classes automatically so
// that you don't have to litter your code with 'include' or 'require'
// statements.
require_once "Zend/Loader.php";
Zend_Loader::registerAutoload();

// Step 3: REQUIRE APPLICATION BOOTSTRAP: Perform application-specific setup
// This allows you to setup the MVC environment to utilize. Later you 
// can re-use this file for testing your applications.
// The try-catch block below demonstrates how to handle bootstrap 
// exceptions. In this application, if defined a different 
// APPLICATION_ENVIRONMENT other than 'production', we will output the 
// exception and stack trace to the screen to aid in fixing the issue
try {
    require '../application/bootstrap.php';
} catch (Exception $exception) {
    echo '<html><body><center>'
       . 'An exception occured while bootstrapping the application.';
    if (defined('APPLICATION_ENVIRONMENT')
        && APPLICATION_ENVIRONMENT != 'production'
    ) {
        echo '<br /><br />' . $exception->getMessage() . '<br />'
           . '<div align="left">Stack Trace:' 
           . '<pre>' . $exception->getTraceAsString() . '</pre></div>';
    }
    echo '</center></body></html>';
    exit(1);
}


// Step 4: DISPATCH:  Dispatch the request using the front controller.
// The front controller is a singleton, and should be setup by now. We 
// will grab an instance and call dispatch() on it, which dispatches the
// current request.
Zend_Controller_Front::getInstance()->dispatch();
