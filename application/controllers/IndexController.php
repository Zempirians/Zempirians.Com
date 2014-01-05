<?php

class IndexController extends Zend_Controller_Action 
{
	function init()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "index";
		$wmf_ns->mod     	= "index";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->theme 		= "0";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
	}

	function indexAction()
	{
		$this->_redirect('about/splash');
	}

}

