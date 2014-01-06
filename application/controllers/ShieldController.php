<?php

class ShieldController extends Zend_Controller_Action 
{
	function init()
	{

	}

	function indexAction()
	{
		$this->_redirect('shield/login');
	}

	function loginAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "login";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function registerAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "register";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function thanksAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "thanks";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function verifyAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "verify";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$a = $this->getRequest()->getParam('code');
		$this->view->code = htmlspecialchars($a);
	
		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function nullifyAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "nullify";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$a = $this->getRequest()->getParam('code');
		$this->view->code = $this->_helper->shieldsup->paramfilter($a);

		$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
		$this->_helper->layout->setLayout('core.layout');
	}

	function createAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "create";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$email      = $this->_request->getPost('email'); 
		$again      = $this->_request->getPost('again');
		if (!$email || !$again) { $this->_redirect('shield/trap'); }
		if ($email != $again) { $this->_redirect('shield/trap'); }
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){ $this->_redirect('shield/trap'); }

		$worm = $this->_helper->accounts->checkemail($email);


		if ($worm == "YAY") {
			$this->_helper->accounts->reqcreate($email);
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
 			$this->_redirect('shield/thanks');
		} else {
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
			$this->_redirect('shield/trap');
		}
	}


	function authAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "auth";
		$wmf_ns->descrip = "submit";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		//$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		if($this->_request->isPost()) {
			$auth = Zend_Auth::getInstance();
			$auth->clearIdentity();

			$username = $this->_request->getPost('username'); 
			$password = $this->_request->getPost('password');

			$boola = $this->_helper->shieldsup->paramtxt($username);
			$boolb = $this->_helper->shieldsup->paramtxt($password);

			$c_username = $this->_helper->shieldsup->paramfilter($username);
			$c_password = $this->_helper->shieldsup->paramfilter($password);

			if ($boola == "YAY" && $boolb == "YAY") {
				$xray = Zend_Registry::getInstance();
				$config = array(
					'host'     => $xray['host'],
					'username' => $xray['username'],
					'password' => $xray['password'],
					'dbname'   => $xray['dbname']
				);
				$db = Zend_Db::factory('Pdo_Mysql', $config);
				$authAdapter = new Zend_Auth_Adapter_DbTable($db);
				$authAdapter
					->setTableName('authorize')
					->setIdentityColumn('username')
					->setCredentialColumn('password');
				$authAdapter
					->setIdentity($c_username)
					->setCredential($c_password);

				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($authAdapter);
				$db->closeConnection();

			        if($result->isValid()) {
					$userInfo = $authAdapter->getResultRowObject(null, 'password');
					$authStorage = $auth->getStorage();
					$authStorage->write($userInfo);

					$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
 					$this->_redirect('account/profile');
				}
				else {
					$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
					$this->_redirect('shield/errors');
				}
			} else {
				$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
				$this->_redirect('shield/trap');
			}
		}
		else {
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
			$this->_redirect('shield/errors');
		}
	}

	function vgoAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "vgo";
		$wmf_ns->descrip = "submit";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		//if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$a = $this->_request->getPost('code');
		$b = $this->_request->getPost('email');

		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->parameml($b);

		$this->_helper->layout->setLayout('core.layout');

		if ($boola == "YAY" && $boolb == "YAY") {
			$w0rm = $this->_helper->accounts->submitverify($a,$b);
			if ($w0rm == "YAY") {
				$this->view->w0rm = "YAY";
				$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
			} else {
				$this->view->w0rm = "UGH";
				$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
			}
		} else {
			$this->view->w0rm = "UGH";
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
			$this->_redirect('shield/trap');
		}
	}

	function ngoAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "ngo";
		$wmf_ns->descrip = "submit";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = $this->_helper->myprofile->numtoval('worm');
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);

		$timeban = $this->_helper->shieldsup->timeban($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip);
		if ($timeban == "UGH") { $this->_redirect('shield/timeban'); }

		$a = $this->_request->getPost('code');
		$b = $this->_request->getPost('email');

		$boola = $this->_helper->shieldsup->paramnum($a);
		$boolb = $this->_helper->shieldsup->parameml($b);

		$this->_helper->layout->setLayout('core.layout');

		if ($boola == "YAY" && $boolb == "YAY") {
			$w0rm = $this->_helper->accounts->submitnullify($a,$b);
			if ($w0rm == "YAY") {
				$this->view->w0rm = "YAY";
				$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'1');
			} else {
				$this->view->w0rm = "UGH";
				$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
			}
		} else {
			$this->view->w0rm = "UGH";
			$this->_helper->shieldsup->surflog($wmf_ns->mod,$wmf_ns->page,$wmf_ns->descrip,'0');
			$this->_redirect('shield/trap');
		}
	}

	function trapAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "trap";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$this->_helper->pagestats->hacked($_SERVER["REMOTE_ADDR"]);
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->layout->setLayout('core.layout');
	}

	function timebanAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "timeban";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->layout->setLayout('core.layout');
	}

	function errorsAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "shield";
		$wmf_ns->mod     = "errors";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$this->_helper->pagestats->errors($_SERVER["REMOTE_ADDR"]);
		$wmf_ns->stats   = $this->_helper->pagestats->log($wmf_ns->page,$wmf_ns->mod);
		$this->_helper->layout->setLayout('core.layout');
	}

	function logoutAction()
	{
		$wmf_ns          = new Zend_Session_Namespace('SPLOIT');
		$wmf_ns->page    = "logout";
		$wmf_ns->mod     = "shield";
		$wmf_ns->descrip = "click";
		$wmf_ns->grant   = "yes";
		$wmf_ns->rights  = "guest";
		$this->_helper->layout->setLayout('core.layout');
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
	}

}