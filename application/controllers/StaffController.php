<?php

class StaffController extends Zend_Controller_Action 
{
	function init()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('shield/login');
		}
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		if ($userInfo->rights < 2) {
			$this->_redirect('shield/trap');
		}

	}

	function indexAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "index";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function curriculumAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "curriculum";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$newlist = $this->_helper->staff->schoollist('1');
		$this->view->newlist = $newlist;

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function lookcurriculumAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "lookcurriculum";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->stdin = $a; }
		else { $this->_redirect('shield/trap'); }

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function editcurriculumAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "editcurriculum";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->stdin = $a; }
		else { $this->_redirect('shield/trap'); }

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function addcurriculumAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "addcurriculum";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

	}

	function curriculumsubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "curriculumsubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_level');
		$c = $this->getRequest()->getParam('s_other');
		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->staff->gocurriculum($a,$b,$c);
			if ($decide == "YAY") { $this->_redirect('staff/curriculum'); }
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function curriculumsaveAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "curriculumsave";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_level');
		$c = $this->getRequest()->getParam('s_other');
		$d = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);
		$boold = $this->_helper->shieldsup->paramnum($d);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && $boold == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->staff->savecurriculum($a,$b,$c,$d);
			if ($decide == "YAY") { $this->_redirect('staff/curriculum'); }
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function courseAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "course";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$newlist = $this->_helper->staff->schoollist('2');
		$this->view->newlist = $newlist;

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function lookcourseAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "lookcourse";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->stdin = $a; }
		else { $this->_redirect('shield/trap'); }

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function editcourseAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "editcourse";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->stdin = $a; }
		else { $this->_redirect('shield/trap'); }

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function addcourseAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "courseadd";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

	}

	function coursesubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "coursesubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_level');
		$c = $this->getRequest()->getParam('s_other');
		$d = $this->getRequest()->getParam('s_curriculum');
		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);
		$boold = $this->_helper->shieldsup->paramnum($d);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && $boold == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->staff->gocourse($a,$b,$c,$d);
			if ($decide == "YAY") { $this->_redirect('staff/course'); }
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function coursesaveAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "coursesave";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_level');
		$c = $this->getRequest()->getParam('s_other');
		$d = $this->getRequest()->getParam('s_curriculum');
		$e = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);
		$boold = $this->_helper->shieldsup->paramnum($d);
		$boole = $this->_helper->shieldsup->paramnum($e);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && $boold == "YAY" && $boole == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->staff->savecourse($a,$b,$c,$d,$e);
			if ($decide == "YAY") { $this->_redirect('staff/course'); }
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function acceptcourseAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "acceptcourse";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->staff->course($a,"1");
			if ($decide == "YAY") {
				 $this->_redirect('staff/course');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function denycourseAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "denycourse";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->staff->course($a,"0");
			if ($decide == "YAY") {
				 $this->_redirect('staff/course');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function lessonAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "lesson";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$newlist = $this->_helper->staff->schoollist('3');
		$this->view->newlist = $newlist;

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function looklessonAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "looklesson";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->stdin = $a; }
		else { $this->_redirect('shield/trap'); }

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function editlessonAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "editlesson";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->stdin = $a; }
		else { $this->_redirect('shield/trap'); }

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function addlessonAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "addlesson";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

	}

	function lessonsubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "lessonsubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_level');
		$c = $this->getRequest()->getParam('s_other');
		$d = $this->getRequest()->getParam('s_curriculum');
		$e = $this->getRequest()->getParam('s_course');
		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);
		$boold = $this->_helper->shieldsup->paramnum($d);
		$boole = $this->_helper->shieldsup->paramnum($e);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && $boold == "YAY" && $boole == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->staff->golesson($a,$b,$c,$d,$e);
			if ($decide == "YAY") { $this->_redirect('staff/lesson'); }
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function lessonsaveAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "staff";
		$wmf_ns->mod     	= "lessonsave";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('staff.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_name');
		$b = $this->getRequest()->getParam('s_level');
		$c = $this->getRequest()->getParam('s_other');
		$d = $this->getRequest()->getParam('s_curriculum');
		$e = $this->getRequest()->getParam('s_course');
		$f = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);
		$boold = $this->_helper->shieldsup->paramnum($d);
		$boole = $this->_helper->shieldsup->paramnum($e);
		$boolf = $this->_helper->shieldsup->paramnum($f);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && $boold == "YAY" && $boole == "YAY" && $boolf == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->staff->savelesson($a,$b,$c,$d,$e,$f);
			if ($decide == "YAY") { $this->_redirect('staff/lesson'); }
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function acceptlessonAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "acceptlesson";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->staff->lesson($a,"1");
			if ($decide == "YAY") {
				 $this->_redirect('staff/lesson');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}

	function denylessonAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "staff";
		$wmf_ns->mod      = "denylesson";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		if ($boola == "YAY") {
			$decide = $this->_helper->staff->lesson($a,"0");
			if ($decide == "YAY") {
				 $this->_redirect('staff/lesson');
			}
			else { $this->_redirect('shield/trap'); }
		}
		else { $this->_redirect('shield/trap');	}

		$picklayout = $this->_helper->layout->setLayout('staff.layout');
	}
}