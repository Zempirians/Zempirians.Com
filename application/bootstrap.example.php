<?php
// application/bootstrap.php
//
// Step 1: APPLICATION CONSTANTS - Set the constants to use in this application.
// These constants are accessible throughout the application, even in ini
// files. We optionally set APPLICATION_PATH here in case our entry point
// isn't index.php (e.g., if required from our test suite or a script).
defined('APPLICATION_PATH') or define('APPLICATION_PATH', dirname(__FILE__));
//defined('APPLICATION_ENVIRONMENT') or define('APPLICATION_ENVIRONMENT', 'development');
defined('APPLICATION_ENVIRONMENT') or define('APPLICATION_ENVIRONMENT', 'production');

// Step 2: FRONT CONTROLLER - Get the front controller.
// The Zend_Front_Controller class implements the Singleton pattern, which is a
// design pattern used to ensure there is only one instance of
// Zend_Front_Controller created on each request.
$frontController = Zend_Controller_Front::getInstance();

// Step 3: CONTROLLER DIRECTORY SETUP - Point the front controller to your action
// controller directory.
$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');

// Step 4: APPLICATION ENVIRONMENT - Set the current environment.
// Set a variable in the front controller indicating the current environment --
// commonly one of development, staging, testing, production, but wholly
// dependent on your organization's and/or site's needs.
$frontController->setParam('env', APPLICATION_ENVIRONMENT);
Zend_Layout::startMvc(APPLICATION_PATH . '/layouts');

// VIEW SETUP - Initialize properties of the view object
// The Zend_View component is used for rendering views. Here, we grab a "global"
// view instance from the layout object, and specify the doctype we wish to
// use. In this case, XHTML1 Strict.
$view = Zend_Layout::getMvcInstance()->getView();
$view->doctype('XHTML1_STRICT');

// REGISTRY - setup the application registry
// An application registry allows the application to store application
// necessary objects into a safe and consistent (non global) place for future
// retrieval.  This allows the application to ensure that regardless of what
// happends in the global scope, the registry will contain the objects it
// needs.
Zend_Registry::set('host', 'hostname');
Zend_Registry::set('username', 'user');
Zend_Registry::set('password', 'pass');
Zend_Registry::set('dbname', 'database');

Zend_Session::start();

// Action Helpers
Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/plugins');
//$hooks = Zend_Controller_Action_HelperBroker::getStaticHelper('Hooks');
//Zend_Controller_Action_HelperBroker::addHelper($hooks);

// Step 5: CLEANUP - Remove items from global scope.
// This will clear all our local boostrap variables from the global scope of
// this script (and any scripts that called bootstrap).  This will enforce
// object retrieval through the applications's registry.
unset($frontController, $view, $configuration);
