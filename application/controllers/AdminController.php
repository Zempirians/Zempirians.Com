<?php

class AdminController extends Zend_Controller_Action 
{
	function init()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('shield/login');
		}
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		if ($userInfo->rights < 3) {
			$this->_redirect('shield/trap');
		}
	}

	function indexAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "index";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.Index";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->ennew = $this->_helper->enrollment->newapp('worm');
		$this->view->enold = $this->_helper->enrollment->oldapp('worm');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}


	function newappsAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "newapps";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.Newapps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->newlist = $this->_helper->enrollment->allnewapp('worm');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function editappAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "editapp";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.Editapps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "UGH") { $this->_redirect('shield/trap'); } else { $this->view->stdin = $a; }

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}


}