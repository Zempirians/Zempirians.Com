<?php

class ArchiveController extends Zend_Controller_Action 
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

	function uploadAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "archive";
		$wmf_ns->mod      = "upload";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Archive.Upload";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$picklayout = $this->_helper->layout->setLayout('account.layout');
	}


	function submitAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "archive";
		$wmf_ns->mod      = "upload:submit";
		$wmf_ns->descrip  = "submit";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->jdwidth  = "550";
		$wmf_ns->jdheight = "420";
		$wmf_ns->jdtitle  = "Archive.Upload";
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('s_title');
		$b = $this->getRequest()->getParam('s_desc');
		$c = $this->getRequest()->getParam('s_level');

		$boola = $this->_helper->shieldsup->paramtxt($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);
		$boolc = $this->_helper->shieldsup->paramnum($c);

		$allowext = array("txt", "pdf");
		$temp     = explode(".", $_FILES["s_file"]["name"]);
		$ext      = end($temp);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && in_array($ext, $allowext)) {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$b = $this->_helper->shieldsup->paramfilter($b);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$hack = $this->_helper->myarchive->addfile($a,$b,$c,$_FILES["s_file"]["tmp_name"],$ext);
			if ($hack == "YAY") { $this->_redirect('account/profile'); }
		}
		else { $this->_redirect('shield/trap');	}
	}
}