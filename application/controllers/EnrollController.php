<?php

class EnrollController extends Zend_Controller_Action 
{
	function init()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('shield/login');
		}
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		if ($userInfo->rights < 1) {
			$this->_redirect('shield/login');
		}
		if ($userInfo->rights != 1) {
			$this->_redirect('shield/trap');
		}
	}

	function appAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "enroll";
		$wmf_ns->mod     = "app";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "420";
		$wmf_ns->jdtitle	= "Enroll.Application";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}


}