<?php

class MailController extends Zend_Controller_Action 
{
	function init()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()) { $this->_redirect('shield/login'); }

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		if ($userInfo->rights < 1) { $this->_redirect('shield/trap'); }
	}

	function inboxAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "inbox";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats	 = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function readAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "read";
		$wmf_ns->descrip = "read";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "UGH") { $this->_redirect('shield/trap'); } else { $this->view->stdin = $a; }
	}

	function replyAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "reply";
		$wmf_ns->descrip = "read";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "UGH") { $this->_redirect('shield/trap'); } else { $this->view->stdin = $a; }
	}

	function replysubmitAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "reply";
		$wmf_ns->descrip = "read";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('id');
		$b = $this->getRequest()->getParam('note');
		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);

		if ($boola == "YAY" && $boolb == "YAY") {
			$b = $this->_helper->shieldsup->paramfilter($b);
			$hack = $this->_helper->mailcheck->reply($a,$b);
			if ($hack == "YAY") { $this->_redirect('mail/inbox'); }
		}
		else { $this->_redirect('shield/trap');	}
	}

	function killAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "kill";
		$wmf_ns->descrip = "kill";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$boolb = $this->_helper->mailcheck->delete($a);
			if ($boolb == "YAY") { $this->_redirect('mail/inbox'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function chatAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "chat";
		$wmf_ns->descrip = "view";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$this->view->log = $a;
		}
		else { $this->_redirect('shield/trap'); }
	}

	function composeAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "compose";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$this->view->log = $a;
		}
		else { $this->_redirect('shield/trap'); }
	}

	function composesubmitAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "mail";
		$wmf_ns->mod     = "compose";
		$wmf_ns->descrip = "submit";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('id');
		$b = $this->getRequest()->getParam('note');
		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);

		if ($boola == "YAY" && $boolb == "YAY") {
			$b = $this->_helper->shieldsup->paramfilter($b);
			$decide = $this->_helper->mailcheck->compose($a,$b);
			if ($decide == "YAY") { $this->_redirect('team/board'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

}