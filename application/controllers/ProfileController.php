<?php

class ProfileController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function memberAction()
	{
		$wmf_ns           = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page     = "profile";
		$wmf_ns->mod      = "view";
		$wmf_ns->descrip  = "click";
		$wmf_ns->grant    = "yes";
		$wmf_ns->rights   = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats    = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$picklayout = $this->_helper->layout->setLayout('core.layout');

		$a = $this->getRequest()->getParam('stdin');

		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$hack = $this->_helper->pubprofile->showme($a);
			if ($hack != "YAY") {
				$this->view->stdin = "end";
			}
			else { $this->view->stdin = $a; }
		}
		else { $this->_redirect('shield/trap');	}
	}
}