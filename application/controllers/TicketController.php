<?php

class TicketController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function reportAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "ticket";
		$wmf_ns->mod     	= "report";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Ticket.Report";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

			$a = $this->getRequest()->getParam('stdin');
			$boola = $this->_helper->shieldsup->paramnum($a);

			if ($boola == "YAY") {
				$this->view->stdin = $a;
				//$this->_helper->level->gain('console','host:submit','1');
			} else {
				$this->_redirect('shield/trap');
			}
	}

	function reportsubmitAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "ticket";
		$wmf_ns->mod     	= "reportsubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Ticket.ReportSubmit";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');

			$a = $this->getRequest()->getParam('stdin');
			$b = $this->getRequest()->getParam('reason');

			$boola = $this->_helper->shieldsup->paramnum($a);
			$boolb = $this->_helper->shieldsup->paramnum($b);

			if ($boola == "YAY" && $boola == "YAY" && $b > 0 && $b < 5) {
				$booltest = $this->_helper->ticket->report($a,$b,$_SERVER["REMOTE_ADDR"]);
				if ($booltest == "UGH") {
					$this->_redirect('shield/trap');
				}
			} else {
				$this->_redirect('shield/trap');
			}
	}

	function issuesAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "ticket";
		$wmf_ns->mod     	= "issues";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Ticket.Issues";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function solutionsAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "ticket";
		$wmf_ns->mod     	= "solutions";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->jdwidth 	= "700";
		$wmf_ns->jdheight	= "450";
		$wmf_ns->jdtitle	= "Ticket.Solutions";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

}

