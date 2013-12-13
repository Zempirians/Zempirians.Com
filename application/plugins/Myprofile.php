<?php

class Zend_Controller_Action_Helper_Myprofile extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function numtoval($str)
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		switch ($userInfo->rights) {
			case 6:
				$myvalue = "founder";
				break;
			case 5:
				$myvalue = "executive";
				break;
			case 4:
				$myvalue = "admin";
				break;
			case 3:
				$myvalue = "staff";
				break;
			case 2:
				$myvalue = "student";
				break;
			case 1:
				$myvalue = "user";
				break;
			default:
				$myvalue = "guest";
				break;
		}

		return $myvalue;
	}

	function enrapp($str)
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

		$x = "UGH";

		$queryF = $db->select()
			->from('profile_app')
			->where('gid = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
			$x = "YAY";
		}
		else {
			$x = "UGH";
		}

		return $x;
	}

	function enrollnow($a,$b,$c,$d,$e,$f,$g,$h)
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

		$x = "UGH";

		$queryF = $db->select()
			->from('profile_app')
			->where('gid = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
 			$set = array( 
				'gid'        => $userInfo->id,
				'age'        => $a,
				'gender'     => $c,
				'timezone'   => $b,
				'reddit'     => $d,
				'irc'        => $e,
				'email'      => $f,
				'position'   => $g,
				'details'    => $h,
				'en'         => "1",
				'create'     => date("Y-m-d G:i:s"),
				'admin_id'   => "0",
				'admin_vote' => "0",
				'admin_date' => "0000-00-00 00:00:00",
				'ip'         => $_SERVER['REMOTE_ADDR']
			);
			$db->insert('profile_app', $set);

			$x = "YAY";
		}

		return $x;
	}

}

