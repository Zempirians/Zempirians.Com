<?php

class BlogController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function pusheaxAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "blog";
		$wmf_ns->mod     	= "pusheax";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Blog.Pusheax";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('reddit.layout');
	}


}

