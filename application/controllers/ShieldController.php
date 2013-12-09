<?php

class ShieldController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function trapAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "trap";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "400";
		$wmf_ns->jdtitle	= "Zempire Protected - Possible Hack Attempt";
		$this->_helper->pagestats->hacked($_SERVER["REMOTE_ADDR"]);
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->layout->setLayout('shield.layout');
	}

	function timebanAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "timeban";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "400";
		$wmf_ns->jdtitle	= "Zempire Protected - Time Ban";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->layout->setLayout('shield.layout');
	}

	function errorsAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "errors";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "400";
		$wmf_ns->jdtitle	= "Zempire Protected - Possible Hack Attempt";
		$this->_helper->pagestats->errors($_SERVER["REMOTE_ADDR"]);
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->layout->setLayout('shield.layout');
	}

	function logoutAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "logout";
		$wmf_ns->mod     = "shield";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = "guest";
		$wmf_ns->jdwidth 	= "400";
		$wmf_ns->jdheight	= "250";
		$wmf_ns->jdtitle	= "Sploit.Shield/Logout";
		$this->_helper->layout->setLayout('core.layout');
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
	}

}