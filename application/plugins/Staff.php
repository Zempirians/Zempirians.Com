<?php

class Zend_Controller_Action_Helper_Staff extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function schoollist($str)
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

		switch ($str) {
			case 1:
				$myvalue = "school_curriculum";
				break;
			case 2:
				$myvalue = "school_course";
				break;
			case 3:
				$myvalue = "school_lesson";
				break;
			default:
				$myvalue = "ugh";
				break;
		}

		if ($myvalue == "ugh") {
			$resultF = "ugh";
		}
		else {
			$queryF = $db->select()
				->from($myvalue)
				->where('en = ?', "1")
				->where('admin_vote = ?', "1");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}


	function gocurriculum($name,$level,$desc)
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

		if ($userInfo->rights > 1) {
 			$set = array( 
				'name'         => $name,
				'description'  => $desc,
				'level'        => $level,
				'owner_id'     => $userInfo->id,
				'owner_create' => date("Y-m-d G:i:s"),
				'owner_ip'     => $_SERVER['REMOTE_ADDR'],
				'admin_id'     => "0",
				'admin_create' => "0000-00-00 00:00:00",
				'admin_vote'   => "0",
				'en'           => "1"
			);
			$db->insert('school_curriculum', $set);
			$x = "YAY";
		}

		return $x;
	}

	function gocourse($name,$level,$desc,$parent)
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

		if ($userInfo->rights > 1) {
 			$set = array( 
				'name'         => $name,
				'description'  => $desc,
				'level'        => $level,
				'pid'          => $parent,
				'owner_id'     => $userInfo->id,
				'owner_create' => date("Y-m-d G:i:s"),
				'owner_ip'     => $_SERVER['REMOTE_ADDR'],
				'admin_id'     => "0",
				'admin_create' => "0000-00-00 00:00:00",
				'admin_vote'   => "0",
				'en'           => "1"
			);
			$db->insert('school_course', $set);
			$x = "YAY";
		}

		return $x;
	}

	function golesson($name,$level,$desc,$parent,$child)
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

		if ($userInfo->rights > 1) {
 			$set = array( 
				'name'         => $name,
				'description'  => $desc,
				'level'        => $level,
				'pid'          => $parent,
				'cid'          => $child,
				'owner_id'     => $userInfo->id,
				'owner_create' => date("Y-m-d G:i:s"),
				'owner_ip'     => $_SERVER['REMOTE_ADDR'],
				'admin_id'     => "0",
				'admin_create' => "0000-00-00 00:00:00",
				'admin_vote'   => "0",
				'en'           => "1"
			);
			$db->insert('school_lesson', $set);
			$x = "YAY";
		}

		return $x;
	}
}

