<?php

class IndexController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function indexAction()
	{
		$this->_redirect('about/academy');
	}

}

