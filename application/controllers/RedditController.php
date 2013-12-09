<?php

class RedditController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function blackhatAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "reddit";
		$wmf_ns->mod     	= "blackhat";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Reddit.BlackHat";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function howtohackAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "reddit";
		$wmf_ns->mod     	= "howtohack";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Reddit.HowToHack";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function openhackerAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "reddit";
		$wmf_ns->mod     	= "openhacker";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Reddit.OpenHacker";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

	function shehacksAction()
	{
		// SPLOIT - TIMEBAN
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "reddit";
		$wmf_ns->mod     	= "shehacks";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Reddit.SheHacks";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}

}

