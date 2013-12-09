<?php 
// application/controllers/ErrorController.php

/**
 * ErrorController
 */ 
class ErrorController extends Zend_Controller_Action 
{ 
    /**
     * errorAction() is the action that will be called by the "ErrorHandler" 
     * plugin.  When an error/exception has been encountered
     * in a ZF MVC application (assuming the ErrorHandler has not been disabled
     * in your bootstrap) - the Errorhandler will set the next dispatchable 
     * action to come here.  This is the "default" module, "error" controller, 
     * specifically, the "error" action.  These options are configurable. 
     * 
     * @see http://framework.zend.com/manual/en/zend.controller.plugins.html
     *
     * @return void
     */
    public function errorAction() 
    {
	$this->_redirect('shield/errors');
    } 
}
