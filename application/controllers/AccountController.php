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
			$this->_redirect('shield/trap');
		}
	}

	function profileAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "profile";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Account.Profile";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');
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
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}

	function submithandleAction()
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
		$picklayout = $this->_helper->layout->setLayout('account.layout');

		$x_handle = $this->_helper->shieldsup->paramfilter($this->getRequest()->getParam('handle'));
		$w0rm     = $this->_helper->accounts->checkhandle($x_handle);

		if ($w0rm == "YAY") {
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
			$this->_helper->accounts->changehandle($x_handle);
			$userInfo->handle = $x_handle;
			$this->_redirect('account/profile');
		}
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
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}

	function submitpasswordAction()
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
		$picklayout = $this->_helper->layout->setLayout('account.layout');

		$pass1 = $this->getRequest()->getParam('pass1');
		$pass2 = $this->getRequest()->getParam('pass2');

		if ($pass1 != $pass2 || !pass1 || !$pass2) {
			$w0rm = "UGH";
		} else {
			$x_pass = $this->_helper->shieldsup->paramfilter($this->getRequest()->getParam('pass1'));
			$this->_helper->accounts->changepassword($x_pass);
			$userInfo->password = $x_pass;
			$w0rm = "YAY";
			$this->_redirect('account/profile');
		}
	}

	function addskillAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "skilladd";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Add a new skill to your profile";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}

	function submitskillAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "skill:add";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Engine";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');

		//$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_exp');

		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);

		if ($boola == "YAY" && $boolb == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$b = $this->_helper->shieldsup->paramfilter($b);
			$hack = $this->_helper->myprofile->addskill($a,$b);
			if ($hack == "YAY") { $this->_redirect('account/profile'); }
		}
		else { $this->_redirect('shield/trap');	}
	}

	function addcredAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "credadd";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Add a new skill to your profile";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}

	function submitcredAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "cred:add";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Engine";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');

		//$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_exp');
		$c = $this->getRequest()->getParam('s_other');

		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$b = $this->_helper->shieldsup->paramfilter($b);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$hack = $this->_helper->myprofile->addcred($a,$b,$c);
			if ($hack == "YAY") { $this->_redirect('account/profile'); }
		}
		else { $this->_redirect('shield/trap');	}
	}

	function addexpAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "expadd";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Add a new skill to your profile";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}

	function submitexpAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "exp:add";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Engine";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');

		//$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_exp');
		$c = $this->getRequest()->getParam('s_other');

		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$b = $this->_helper->shieldsup->paramfilter($b);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$hack = $this->_helper->myprofile->addexp($a,$b,$c);
			if ($hack == "YAY") { $this->_redirect('account/profile'); }
		}
		else { $this->_redirect('shield/trap');	}
	}

	function addintrAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "intradd";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Add a new skill to your profile";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}

	function submitintrAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "account";
		$wmf_ns->mod      = "intr:add";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Engine";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
		$picklayout = $this->_helper->layout->setLayout('account.layout');

		//$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_exp');
		$c = $this->getRequest()->getParam('s_other');

		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$b = $this->_helper->shieldsup->paramfilter($b);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$hack = $this->_helper->myprofile->addintr($a,$b,$c);
			if ($hack == "YAY") { $this->_redirect('account/profile'); }
		}
		else { $this->_redirect('shield/trap');	}
	}


}