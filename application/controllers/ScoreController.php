<?php

class ScoreController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function boardAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "score";
		$wmf_ns->mod     	= "board";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

}

