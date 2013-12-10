<?php

class AccountController extends Zend_Controller_Action 
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
	}

	function indexAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "account";
		$wmf_ns->mod     = "index";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "420";
		$wmf_ns->jdtitle	= "Account.Index";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('core.layout');
	}

	function handleAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "account";
		$wmf_ns->mod     = "handle";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "420";
		$wmf_ns->jdtitle	= "Change your handle (nickname)";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('core.layout');
	}

	function handlesubmitAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "account";
		$wmf_ns->mod     = "handle";
		$wmf_ns->descrip = "submit";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth 	= "630";
		$wmf_ns->jdheight	= "275";
		$wmf_ns->jdtitle	= "Handle is now changed";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('core.layout');

		$x_handle = $this->_helper->shieldsup->paramfilter($this->getRequest()->getParam('handle'));
		$w0rm     = $this->_helper->accounts->checkhandle($x_handle);

		if ($w0rm == "YAY") {
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
			$this->_helper->accounts->changehandle($x_handle);
			$userInfo->handle = $x_handle;
		}

		$this->view->w0rm = $w0rm;
	}

	function passwordAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "account";
		$wmf_ns->mod     = "password";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth 	= "550";
		$wmf_ns->jdheight	= "420";
		$wmf_ns->jdtitle	= "Change your password";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('core.layout');
	}

	function passwordsubmitAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "account";
		$wmf_ns->mod     = "password";
		$wmf_ns->descrip = "submit";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth 	= "630";
		$wmf_ns->jdheight	= "275";
		$wmf_ns->jdtitle	= "Password is now changed";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->accounts->layout('password');
		$picklayout = $this->_helper->layout->setLayout('core.layout');

		$pass1 = $this->getRequest()->getParam('pass1');
		$pass2 = $this->getRequest()->getParam('pass2');

		if ($pass1 != $pass2 || !pass1 || !$pass2) {
			$w0rm = "UGH";
		} else {
			$x_pass = $this->_helper->shieldsup->paramfilter($this->getRequest()->getParam('pass1'));
			$this->_helper->accounts->changepassword($x_pass);
			$userInfo->password = $x_pass;
			$w0rm = "YAY";
		}
		$this->view->w0rm = $w0rm;
	}

}