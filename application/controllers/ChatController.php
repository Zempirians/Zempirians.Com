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
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Chat.Stats";
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
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Chat.HowToHack";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function legionAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "legion";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Chat.Legion";
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
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Chat.SheHacks";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function zempireAction()
	{
		// SPLOIT - TIMEBAN
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "zempire";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Chat.Zempire";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function zempiriansAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "chat";
		$wmf_ns->mod     	= "zempirians";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Chat.Zempirians";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}
}

