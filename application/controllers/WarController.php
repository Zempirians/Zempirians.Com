<?php

class WarController extends Zend_Controller_Action 
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

	function indexAction()
	{
		$this->_redirect('war/home');
	}

	function homeAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "home";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
	}

	function journalAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "journal";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;

		$this->view->warlog = $this->_helper->journal->readlog("all","null");
	}

	function scoreAction()
	{
		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "score";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
	}

	function battleAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_redirect('war/warhelp'); }

		// SCOUT STUFF
		$a = $this->_helper->teamcheck->member($userInfo->id);
		$b = $a["team_id"];

		if ($this->_helper->war->prereq($b) == "UGH") { $this->_redirect('war/warhelp'); }
		if ($this->_helper->war->precamp($b) == "UGH") { $this->_redirect('war/warhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "battle";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->campid = $this->_helper->war->getcampid($userInfo->id);
		$this->view->zempirian = $userInfo;
	}


	function detailsAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_redirect('war/warhelp'); }

		// SCOUT STUFF
		$a = $this->_helper->teamcheck->member($userInfo->id);
		$b = $a["team_id"];

		if ($this->_helper->war->prereq($b) == "UGH") { $this->_redirect('war/warhelp'); }
		if ($this->_helper->war->precamp($b) == "UGH") { $this->_redirect('war/warhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "details";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->campid = $this->_helper->war->getcampid($userInfo->id);
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('node');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->node = $a; } else { $this->_redirect('shield/trap'); }
	}


	function hackAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_redirect('war/warhelp'); }

		// SCOUT STUFF
		$a = $this->_helper->teamcheck->member($userInfo->id);
		$b = $a["team_id"];

		if ($this->_helper->war->prereq($b) == "UGH") { $this->_redirect('war/warhelp'); }
		if ($this->_helper->war->precamp($b) == "UGH") { $this->_redirect('war/warhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "hack";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->campid = $this->_helper->war->getcampid($userInfo->id);
		$this->view->zempirian = $userInfo;
		$a = $this->getRequest()->getParam('node');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") { $this->view->node = $a; } else { $this->_redirect('shield/trap'); }
	}


	function teamAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// IF NO TEAM, FORCE OUT
		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_redirect('war/teamhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "team";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$tempA = $this->_helper->team->showplayer("team");
		$this->view->teaminfo = $this->_helper->team->showteam("all",$tempA);
		$this->view->playinfo = $this->_helper->team->showplayer("status");

	}

	function teamhelpAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamhelp";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

	}

	function teamcreateAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "YAY") {
			$this->_redirect('war/teamcreateerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamcreate";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

	}

	function teamaddAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamadd";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;
	}

	function teamaddsubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamaddsubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$stdin = $this->getRequest()->getParam('stdin');
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $stdin)) {
			$this->_redirect('shield/trap');
		}
		else {
			$boola = $this->_helper->teamcheck->add($stdin);
			if ($boola == "YAY") { $this->_redirect('war/team'); }
		}
	}

	function teamjoinAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamjoin";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$boolb = $this->_helper->teamcheck->join($a);
				if ($boolb == "YAY") { $this->_redirect('war/team'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function teamdenyAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamdeny";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$boolb = $this->_helper->teamcheck->deny($a);
				if ($boolb == "YAY") { $this->_redirect('war/team'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function teamsubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "YAY") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamsubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$worm = $this->_helper->shieldsup->paramalpha($a);
		if ($worm == "YAY") {
			$a = $this->_helper->shieldsup->paramfilter($a);
			$decide = $this->_helper->teamcheck->create($a);
			if ($decide == "YAY") {
	 			$this->_redirect('war/team');
			} else {
				$this->_redirect('war/teamfail');
			}
		} else {
			$this->_redirect('shield/trap');
		}
	}

	function teamqueueAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamqueue";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->_helper->teamcheck->lookup($userInfo->id);
		$b = $this->getRequest()->getParam('stdin');

		$boola = $this->_helper->shieldsup->paramnum($b);
		if ($boola == "YAY") {
			$boolb = $this->_helper->teamcheck->queue($a["id"],$b);
			if ($boolb == "YAY") { $this->_redirect('war/team'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function teamerrorAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamerror";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
	}

	function teamcreateerrorAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamcreateerror";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$this->view->zempirian = $userInfo;
	}

	function teamprogressAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamprogress";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('node');
		$b = $this->getRequest()->getParam('opt');

		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		if ($boola == "YAY" && $boolb == "YAY") {
			$this->view->node = $a;
			$this->view->opt  = $b;
		}
		else { $this->_redirect('shield/trap'); }
	}

	function teamprogresssubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") {
			$this->_redirect('war/teamerror');
		}

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "teamprogresssubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('node');
		$b = $this->getRequest()->getParam('opt');
		$c = $this->getRequest()->getParam('stdin');

		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$c = $this->_helper->shieldsup->paramfilter($c);
			$d = $this->_helper->team->showplayer("team");
			$decide = $this->_helper->team->progress($a,$b,$c,$d);
			if ($decide == "YAY") { $this->_redirect('war/team'); }
		}
		else { $this->_redirect('shield/trap'); }
	}


	function hacksubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_redirect('war/warhelp'); }

		// SCOUT STUFF
		$a = $this->_helper->teamcheck->member($userInfo->id);
		$b = $a["team_id"];

		if ($this->_helper->war->prereq($b) == "UGH") { $this->_redirect('war/warhelp'); }
		if ($this->_helper->war->precamp($b) == "UGH") { $this->_redirect('war/warhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "hacksubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->campid = $this->_helper->war->getcampid($userInfo->id);
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('node');
		$b = $this->getRequest()->getParam('stdin');
		$c = $this->getRequest()->getParam('report');
		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramtxt($b);
		$boolc = $this->_helper->shieldsup->paramnum($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$b = $this->_helper->shieldsup->paramfilter($b);
			$determine = $this->_helper->war->hack($a,$c,$b);
			if ($determine == "YAY") { $this->_forward('home'); }
		}
		else { $this->_redirect('shield/trap'); }
	}


	function kickAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// IF NO TEAM, FORCE OUT
		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_redirect('war/warhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "kicksubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->campid = $this->_helper->war->getcampid($userInfo->id);
		$this->view->zempirian = $userInfo;

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$boolb = $this->_helper->teamcheck->kick($a);
				if ($boolb == "YAY") { $this->_redirect('war/team'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function warhelpAction()
	{

		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// IF NO TEAM, FORCE OUT
		$determine = $this->_helper->teamcheck->whoami($userInfo->id);
		if ($determine == "UGH") { $this->_forward('teamhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "warhelp";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
	}

	function adminhelpAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminhelp";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

	}

	function adminAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "admin";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
		$this->view->campid = $this->_helper->war->getcampid($userInfo->id);

		$campid = $this->_helper->admin->mycampid();
		$this->view->xteamcnt = $this->_helper->admin->teamcount($campid);
		$this->view->xteamstr = $this->_helper->admin->teamsget($campid);
	}

	function adminaddcampAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminaddcamp";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
	}

	function adminaddcampsubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminaddcampsubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('c_name');
		$b = $this->getRequest()->getParam('c_admin');
		$boola = $this->_helper->shieldsup->paramalpha($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);

		if ($boola == "YAY" && $boolb == "YAY") {
			$decide = $this->_helper->admin->createcamp($this->_helper->shieldsup->paramfilter($a),$b);
			if ($decide == "YAY") {	$this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function admingocampAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "admingocamp";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$decide = $this->_helper->admin->campopen($a);
			if ($decide == "YAY") { $this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function adminaddnodeAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminaddnode";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');
	}

	function adminaddnodesubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminaddnodesubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('c_local');
		$b = $this->getRequest()->getParam('c_remote');
		$c = $this->getRequest()->getParam('camp_id');
		$boola = $this->_helper->shieldsup->paramalpha($a);
		$boolb = $this->_helper->shieldsup->paramalpha($b);
		$boolc = $this->_helper->shieldsup->paramnum($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$decide = $this->_helper->admin->createnode($a,$b,$c);
			if ($decide == "YAY") {	$this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function admineditnodeAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "admineditnode";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$this->view->node = $a;
		}
		else { $this->_redirect('shield/trap'); }
	}

	function admineditnodesubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "admineditnodesubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('node');
		$b = $this->getRequest()->getParam('c_local');
		$c = $this->getRequest()->getParam('c_remote');
		$d = $this->getRequest()->getParam('c_prpb');
		$e = $this->getRequest()->getParam('c_hrpb');
		$f = $this->getRequest()->getParam('c_prps');
		$g = $this->getRequest()->getParam('c_hrps');
		$h = $this->getRequest()->getParam('c_sysver');
		$i = $this->getRequest()->getParam('c_sshver');
		$j = $this->getRequest()->getParam('c_sshlport');
		$k = $this->getRequest()->getParam('c_sshrport');
		$l = $this->getRequest()->getParam('c_sqlver');
		$m = $this->getRequest()->getParam('c_sqllport');
		$n = $this->getRequest()->getParam('c_sqlrport');
		$o = $this->getRequest()->getParam('c_httpver');
		$p = $this->getRequest()->getParam('c_httplport');
		$q = $this->getRequest()->getParam('c_httprport');
		$r = $this->getRequest()->getParam('c_ftpver');
		$s = $this->getRequest()->getParam('c_ftplport');
		$t = $this->getRequest()->getParam('c_ftprport');

		if (!$a) { $boola = "YAY"; $a = "NULL"; } else { $boola = $this->_helper->shieldsup->paramnum($a); }
		if (!$b) { $boolb = "YAY"; $b = "NULL"; } else { $boolb = $this->_helper->shieldsup->paramtxt($b); }
		if (!$c) { $boolc = "YAY"; $c = "NULL"; } else { $boolc = $this->_helper->shieldsup->paramtxt($c); }
		if (!$d) { $boold = "YAY"; $d = "NULL"; } else { $boold = $this->_helper->shieldsup->paramtxt($d); }
		if (!$e) { $boole = "YAY"; $e = "NULL"; } else { $boole = $this->_helper->shieldsup->paramtxt($e); }
		if (!$f) { $boolf = "YAY"; $f = "NULL"; } else { $boolf = $this->_helper->shieldsup->paramtxt($f); }
		if (!$g) { $boolg = "YAY"; $g = "NULL"; } else { $boolg = $this->_helper->shieldsup->paramtxt($g); }
		if (!$h) { $boolh = "YAY"; $h = "NULL"; } else { $boolh = $this->_helper->shieldsup->paramtxt($h); }
		if (!$i) { $booli = "YAY"; $i = "NULL"; } else { $booli = $this->_helper->shieldsup->paramtxt($i); }
		if (!$j) { $boolj = "YAY"; $j = "NULL"; } else { $boolj = $this->_helper->shieldsup->paramtxt($j); }
		if (!$k) { $boolk = "YAY"; $k = "NULL"; } else { $boolk = $this->_helper->shieldsup->paramtxt($k); }
		if (!$l) { $booll = "YAY"; $l = "NULL"; } else { $booll = $this->_helper->shieldsup->paramtxt($l); }
		if (!$m) { $boolm = "YAY"; $m = "NULL"; } else { $boolm = $this->_helper->shieldsup->paramtxt($m); }
		if (!$n) { $booln = "YAY"; $n = "NULL"; } else { $booln = $this->_helper->shieldsup->paramtxt($n); }
		if (!$o) { $boolo = "YAY"; $o = "NULL"; } else { $boolo = $this->_helper->shieldsup->paramtxt($o); }
		if (!$p) { $boolp = "YAY"; $p = "NULL"; } else { $boolp = $this->_helper->shieldsup->paramtxt($p); }
		if (!$q) { $boolq = "YAY"; $q = "NULL"; } else { $boolq = $this->_helper->shieldsup->paramtxt($q); }
		if (!$r) { $boolr = "YAY"; $r = "NULL"; } else { $boolr = $this->_helper->shieldsup->paramtxt($r); }
		if (!$s) { $bools = "YAY"; $s = "NULL"; } else { $bools = $this->_helper->shieldsup->paramtxt($s); }
		if (!$t) { $boolt = "YAY"; $t = "NULL"; } else { $boolt = $this->_helper->shieldsup->paramtxt($t); }

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY" && $boold == "YAY" && $boole == "YAY" && $boolf == "YAY" && $boolg == "YAY" && $boolh == "YAY" && $booli == "YAY" && $boolj == "YAY" && $boolk == "YAY" && $booll == "YAY" && $boolm == "YAY" && $booln == "YAY" && $boolo == "YAY" && $boolp == "YAY" && $boolq == "YAY" && $boolr == "YAY" && $bools == "YAY" && $boolt == "YAY") {
			$b = $this->_helper->shieldsup->paramfilter($b);
			$c = $this->_helper->shieldsup->paramfilter($c);
			$d = $this->_helper->shieldsup->paramfilter($d);
			$e = $this->_helper->shieldsup->paramfilter($e);
			$f = $this->_helper->shieldsup->paramfilter($f);
			$g = $this->_helper->shieldsup->paramfilter($g);
			$h = $this->_helper->shieldsup->paramfilter($h);
			$i = $this->_helper->shieldsup->paramfilter($i);
			$l = $this->_helper->shieldsup->paramfilter($l);
			$o = $this->_helper->shieldsup->paramfilter($o);
			$r = $this->_helper->shieldsup->paramfilter($r);
			$decide = $this->_helper->admin->editnode($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s,$t);
			if ($decide == "YAY") { $this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function admingonodeAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "admingonode";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$decide = $this->_helper->admin->nodeopen($a);
			if ($decide == "YAY") { $this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }
	}

	function adminsabnodeAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminsabnode";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);
		$this->view->node = $a;

		if ($boola == "UGH") { $this->_redirect('shield/trap'); }
	}

	function adminsabmsgAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminsabmsg";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$b = $this->getRequest()->getParam('opt');
		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$this->view->node = $a;
		$this->view->opt  = $b;

		if ($boola == "UGH" || $boolb == "UGH") { $this->_redirect('shield/trap'); }
	}

	function adminsabnodesubmitAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminsabnodesubmit";
		$wmf_ns->descrip 	= "submit";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('node');
		$b = $this->getRequest()->getParam('opt');
		$c = $this->getRequest()->getParam('c_message');
		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->paramnum($b);
		$boolc = $this->_helper->shieldsup->paramtxt($c);

		if ($boola == "YAY" && $boolb == "YAY" && $boolc == "YAY") {
			$c = $this->_helper->shieldsup->paramfilter($c);
			$decide = $this->_helper->admin->sabotage($a,$b,$c);
			if ($decide == "YAY") { $this->_redirect('war/admin'); }
		} else { $this->_redirect('shield/trap'); }

	}

	function admingoteamAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "admingoteam";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$decide = $this->_helper->admin->goteam($a);
			if ($decide == "YAY") { $this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

	function adminkickteamAction()
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		// APPLIED SECURITY, MUST OWN A CAMPAIGN OR GTFO
		if ($userInfo->campaign < "1") { $this->_redirect('war/adminhelp'); }

		$wmf_ns          	= new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    	= "war";
		$wmf_ns->mod     	= "adminkickteam";
		$wmf_ns->descrip 	= "click";
		$wmf_ns->grant   	= "yes";
		$wmf_ns->stats		= $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('war.layout');

		$a = $this->getRequest()->getParam('stdin');
		$boola = $this->_helper->shieldsup->paramnum($a);

		if ($boola == "YAY") {
			$decide = $this->_helper->admin->kickteam($a);
			if ($decide == "YAY") { $this->_redirect('war/admin'); }
		}
		else { $this->_redirect('shield/trap'); }

	}

}