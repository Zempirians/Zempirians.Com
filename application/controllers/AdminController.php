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

	function appacceptAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "appaccept";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.AppsAccept";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "UGH") {
			$this->_redirect('shield/trap');
		}
		else {
			$resp = $this->_helper->enrollment->doaccept($a);
			if ($resp == "YAY") {
				$this->_redirect('admin/newapps');
			}
			else {
				$this->_redirect('shield/trap');
			}
		}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function appdenyAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "appdeny";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.AppsDeny";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "UGH") {
			$this->_redirect('shield/trap');
		}
		else {
			$resp = $this->_helper->enrollment->dodeny($a);
			if ($resp == "YAY") {
				$this->_redirect('admin/newapps');
			}
			else {
				$this->_redirect('shield/trap');
			}
		}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function acceptappsAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "acceptapps";
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

		$this->view->newlist = $this->_helper->enrollment->acceptapp('worm');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function refuseappsAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "refuseapps";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->newlist = $this->_helper->enrollment->refuseapp('worm');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}


	function profilelistAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "profilelist";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$newlist = $this->_helper->admin->profilelist($a);
			if ($newlist == "ugh") {
				 $this->_redirect('shield/trap');	
			}
			else {
				$this->view->newlist = $newlist;
			}
		}
		else { $this->_redirect('shield/trap');	}


		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function archivelistAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "archivelist";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.Archives";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$newlist = $this->_helper->admin->archivelist($a);
			if ($newlist == "ugh") {
				 $this->_redirect('shield/trap');	
			}
			else {
				$this->view->newlist = $newlist;
			}
		}
		else { $this->_redirect('shield/trap');	}


		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function emailtoolAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "emailtool";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.Archives";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function emailtoolsubmitAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "emailtoolsubmit";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.Archives";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$picklayout = $this->_helper->layout->setLayout('admin.layout');

		$a = $this->getRequest()->getParam('s_group');
		$b = $this->getRequest()->getParam('s_subject');
		$c = $this->getRequest()->getParam('s_message');

		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$answer = $this->_helper->admin->emailtool($a,$b,$c);
			if ($answer == "UGH") {
				 $this->_redirect('shield/trap');	
			}
			else {
				$this->_redirect('admin/index');
			}
		}
		else { $this->_redirect('shield/trap');	}

	}

	function curriculumAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "curriculum";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->newlist = $this->_helper->admin->curriculum('0','view');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function curriculumacceptAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "curriculumaccept";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->admin->curriculum($a,"1");
			if ($decide == "YAY") {
				 $this->_redirect('admin/curriculum');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function curriculumdenyAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "curriculumdeny";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->admin->curriculum($a,"0");
			if ($decide == "YAY") {
				 $this->_redirect('admin/curriculum');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function courseAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "course";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->newlist = $this->_helper->admin->course('0','view');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function courseacceptAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "courseaccept";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->admin->course($a,"1");
			if ($decide == "YAY") {
				 $this->_redirect('admin/course');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function coursedenyAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "coursedeny";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->admin->course($a,"0");
			if ($decide == "YAY") {
				 $this->_redirect('admin/course');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function lessonAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "lesson";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->newlist = $this->_helper->admin->lesson('0','view');

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function lessonacceptAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "lessonaccept";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->admin->lesson($a,"1");
			if ($decide == "YAY") {
				 $this->_redirect('admin/lesson');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}

	function lessondenyAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "admin";
		$wmf_ns->mod      = "lessondeny";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Admin.RefuseApps";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->admin->lesson($a,"0");
			if ($decide == "YAY") {
				 $this->_redirect('admin/lesson');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('admin.layout');
	}


}