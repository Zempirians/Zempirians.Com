<?php

class ChatController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function statsAction()
	{
		// SPLOIT - TIMEBAN
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "stats";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function howtohackAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "howtohack";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function staffAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "staff";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function shehacksAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "shehacks";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function academyAction()
	{
		// SPLOIT - TIMEBAN
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "academy";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}
}

