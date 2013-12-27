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
				$myvalue = "administrator";
				break;
			case 3:
				$myvalue = "dev team";
				break;
			case 2:
				$myvalue = "teacher";
				break;
			case 1:
				$myvalue = "student";
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

	function enrollnow($g,$h)
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

	function addskill($a,$b)
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

		$set = array( 
			'gid'        => $userInfo->id,
			'created'    => date("Y-m-d G:i:s"),
			'skill'      => $a,
			'years'      => $b,
			'other'      => "none",
			'ip'         => $_SERVER['REMOTE_ADDR'],
			'place'      => "0",
			'en'         => "1"
		);
		$db->insert('profile_skills', $set);

		$x = "YAY";

		return $x;
	}

	function addcred($a,$b,$c)
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

		$set = array( 
			'gid'        => $userInfo->id,
			'created'    => date("Y-m-d G:i:s"),
			'skill'      => $a,
			'years'      => $b,
			'other'      => $c,
			'ip'         => $_SERVER['REMOTE_ADDR'],
			'place'      => "1",
			'en'         => "1"
		);
		$db->insert('profile_skills', $set);

		$x = "YAY";

		return $x;
	}

	function addexp($a,$b,$c)
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

		$set = array( 
			'gid'        => $userInfo->id,
			'created'    => date("Y-m-d G:i:s"),
			'skill'      => $a,
			'years'      => $b,
			'other'      => $c,
			'ip'         => $_SERVER['REMOTE_ADDR'],
			'place'      => "2",
			'en'         => "1"
		);
		$db->insert('profile_skills', $set);

		$x = "YAY";

		return $x;
	}

	function addintr($a,$b,$c)
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

		$set = array( 
			'gid'        => $userInfo->id,
			'created'    => date("Y-m-d G:i:s"),
			'skill'      => $a,
			'years'      => $b,
			'other'      => $c,
			'ip'         => $_SERVER['REMOTE_ADDR'],
			'place'      => "3",
			'en'         => "1"
		);
		$db->insert('profile_skills', $set);

		$x = "YAY";

		return $x;
	}

	function addhist($a,$b)
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

		$set = array( 
			'gid'        => $userInfo->id,
			'created'    => date("Y-m-d G:i:s"),
			'skill'      => $a,
			'years'      => "0",
			'other'      => $b,
			'ip'         => $_SERVER['REMOTE_ADDR'],
			'place'      => "4",
			'en'         => "1"
		);
		$db->insert('profile_skills', $set);

		$x = "YAY";

		return $x;
	}

	function rmskill($a)
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

		$set = array( 
			'en' => "0"
		);
		$where = array();
		$where[] = $db->quoteInto('id = ?', $a);
		$where[] = $db->quoteInto('gid = ?', $userInfo->id);
		$db->update('profile_skills', $set, $where);

		$x = "YAY";

		return $x;
	}

	function rmfile($a)
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

		$set = array( 
			'en' => "0"
		);
		$where = array();
		$where[] = $db->quoteInto('id = ?', $a);
		$where[] = $db->quoteInto('gid = ?', $userInfo->id);
		$db->update('archives', $set, $where);

		$x = "YAY";

		return $x;
	}

}

