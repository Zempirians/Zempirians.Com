<?php

class Zend_Controller_Action_Helper_Accounts extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function layout($str)
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		switch ($userInfo->rights) {
			case 1:
				$myvalue = "user";
				break;
			default:
				$myvalue = "guest";
				break;
		}

		return $myvalue ."_account_". $str;
	}

	function paramnum($sxint)
	{
		$lockdown = "UGH";
		$envbox   = htmlspecialchars($sxint);
		if (is_numeric($envbox)) {
			$lockdown = "YAY";
		}
		return $lockdown;
	}

	function reqcreate($text)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		$c_text = htmlspecialchars($text);
		$c_auth = mt_rand();
		// SUBMIT NEW REQUEST
		$set = array( 
			'auth'     => "request",
			'authcode' => $c_auth,
			'email'    => $c_text,
			'cip'      => $_SERVER['REMOTE_ADDR']
		);
		$db->insert('authnewb', $set);

		// GENERATE CONTENT
		$bodHTML = "";
		$bodHTML .= "Recently an individual used this email to request access to the HowToHack Academy provided by Zempirians. Please follow the instructions below to either continue setting up your account or cancel the account creation.\n\n";
		$bodHTML .= "YES, finish setting up my account to access awesomecakes! \n";
		$bodHTML .= "http://www.zempirians.com/shield/verify/?code=". $c_auth ."\n\n";
		$bodHTML .= "NO, delete my information from your silly website! \n";
		$bodHTML .= "http://www.zempirians.com/shield/nullify/?code=". $c_auth ."\n\n";
		$bodHTML .= "NOTE: If any problems occur, please contact uberlame@zempirians.com by email.";

		// SEND MAIL
		mail($c_text , "Requested Access", $bodHTML, "From: uberlame@zempirians.com");
	}

	function submitverify ($sa,$sb)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$c_code  = htmlspecialchars($sa);
		$c_email = htmlspecialchars($sb);
		$c_auth  = "request";

		$queryF = $db->select()
			->from('authnewb')
			->where('authcode = ?', $c_code)
			->where('auth = ?', $c_auth)
			->where('email = ?', $c_email);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
			return "UGH";
		} else {
			$set = array( 
				'auth'   => "verify",
				'vip'    => $_SERVER['REMOTE_ADDR'],
				'vstamp' => date("Y-m-d G:i:s")
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('authnewb', $set, $where);

			$new_email = $c_email;
			$new_passd = "temp" . mt_rand();

 			$set = array( 
				'auth'     => "newb",
				'authcode' => $resultF["authcode"],
				'email'    => $c_email,
				'username' => $new_email,
				'password' => $new_passd,
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'since'    => date("Y-m-d G:i:s")
			);
			$db->insert('authorize', $set);

			// SEND A MESSAGE!
			$queryF = $db->select()
				->from('authorize')
				->where('email = ?', $c_email);
			$resultX = $db->fetchRow($queryF);
			$queryF->reset();

 			$set = array( 
				'send_id' => 1,
				'recv_id' => $resultX["id"],
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'created' => date("Y-m-d G:i:s"),
				'note'    => "Make sure to change your handle and password using the SETTINGS menu. Enjoy and keep it clean!",
				'en'      => "1",
				'subject' => "Welcome!"
			);
			$db->insert('war_inbox', $set);

			// GENERATE CONTENT
			$bodHTML = "";
			$bodHTML .= "Thank you for verifying your email address. Below is your account information to enter the Wargames Panel.\n\n";
			$bodHTML .= "username:: ". $new_email ."\n";
			$bodHTML .= "password:: ". $new_passd ."\n\n";
			$bodHTML .= "NOTE: Please change your password immediately after signing in. Do not share your username or password with anyone. If any problems occur, please contact uberlame@zempirians.com by email.";
			// SEND MAIL
			mail($c_email , "Requested Access", $bodHTML, "From: uberlame@zempirians.com");

			return "YAY";
		}
	}

	function submitnullify ($sa,$sb)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$c_code  = htmlspecialchars($sa);
		$c_email = htmlspecialchars($sb);
		$c_auth  = "request";

		$queryF = $db->select()
			->from('authnewb')
			->where('authcode = ?', $c_code)
			->where('auth = ?', $c_auth)
			->where('email = ?', $c_email);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
			return "UGH";
		} else {
			$set = array( 
				'auth'   => "nullify",
				'nip'    => $_SERVER['REMOTE_ADDR'],
				'nstamp' => date("Y-m-d G:i:s")
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('authnewb', $set, $where);

			return "YAY";
		}
	}

	function checkhandle($text)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		$c_text = htmlspecialchars($text);
	// CHECK FOR DUPLICATE HANDLE
		$queryF = $db->select()
			->from('authorize')
			->where('handle = ?', $c_text);
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		$bob = 0;
		foreach ($resultF as $result) {
			++$bob;
		}

		if ($bob == 0) {
			return "YAY";
		} else {
			return "UGH";
		}
	}

	function checkemail($text)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		$c_text = htmlspecialchars($text);
		$queryF = $db->select()
			->from('authorize')
			->where('email = ?', $c_text);
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		$bob = 0;
		foreach ($resultF as $result) {
			++$bob;
		}

		if ($bob == 0) {
			return "YAY";
		} else {
			return "UGH";
		}
	}

	function changehandle($text)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		$c_text = htmlspecialchars($text);
	// SUBMIT NEW HANDLE
		$set = array(
			'handle' => $c_text
		);
		$where = $db->quoteInto('id = ?', $userInfo->id);
		$db->update('authorize', $set, $where);
	// LOG OLD HANDLE
		$set = array (
			'owner'    => $userInfo->id,
			'hand_old' => $userInfo->handle,
			'hand_new' => $c_text,
			'ip'       => $_SERVER['REMOTE_ADDR']
		);
		$db->insert('log_chg_handle', $set);
	}

	function changepassword($text)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		

	// CHECK USER AUTH LEVEL
		$queryF = $db->select()
			->from('authorize')
			->where('id = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();
		if ($resultF["auth"] == "newb") {
			$set = array( 
				'auth'   => "uber"
			);
			$where = $db->quoteInto('id = ?', $userInfo->id);
			$db->update('authorize', $set, $where);
		}
	// SUBMIT NEW PASSWORD
		$set = array(
			'password' => $text
		);
		$where = $db->quoteInto('id = ?', $userInfo->id);
		$db->update('authorize', $set, $where);
	// LOG OLD PASSWORD
		$set = array (
			'owner'    => $userInfo->id,
			'pass_new' => $text,
			'ip'       => $_SERVER['REMOTE_ADDR']
		);
		$db->insert('log_chg_pass', $set);
	}

	function changeemail($text)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		$c_text = htmlspecialchars($text);
	// SUBMIT NEW EMAIL
		$set = array(
			'email'    => $c_text,
			'username' => $c_text
		);
		$where = $db->quoteInto('id = ?', $userInfo->id);
		$db->update('authorize', $set, $where);
	// LOG OLD EMAIL
		$set = array (
			'owner'    => $userInfo->id,
			'mail_old' => $userInfo->email,
			'mail_new' => $c_text,
			'ip'       => $_SERVER['REMOTE_ADDR']
		);
		$db->insert('log_chg_mail', $set);

		$userInfo->email    = $c_text;
		$userInfo->username = $c_text;

			// GENERATE CONTENT
			$bodHTML = "";
			$bodHTML .= "Thank you for changing your email address. Below is your account information to enter the HowToHack Academy provided by Zempirians.\n\n";
			$bodHTML .= "username:: ". $c_text ."\n\n";
			$bodHTML .= "NOTE: Do not share your username or password with anyone. If any problems occur, please contact uberlame@zempirians.com by email.";
			// SEND MAIL
			mail($c_text , "Access Changed", $bodHTML, "From: uberlame@zempirians.com");

			return "YAY";
	}

}

