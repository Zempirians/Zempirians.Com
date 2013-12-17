<?php

class Zend_Controller_Action_Helper_Enrollment extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function allnewapp($str)
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

		$queryF = $db->select()
			->from('profile_app')
			->where('admin_vote = ?', '0');
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		return $resultF;
	}

	function newapp($str)
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

		$queryF = $db->select()
			->from('profile_app', array("hax"=>"COUNT(*)"))
			->where('admin_vote = ?', '0');
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		return $resultF["hax"];
	}

	function acceptapp($str)
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

		$queryF = $db->select()
			->from('profile_app')
			->where('admin_vote = ?', '1');
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		return $resultF;
	}

	function refuseapp($str)
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

		$queryF = $db->select()
			->from('profile_app')
			->where('admin_vote = ?', '2');
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		return $resultF;
	}

	function doaccept($str)
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

		$x = "UGH";

		$queryF = $db->select()
			->from('profile_app')
			->where('admin_vote = ?', '0')
			->where('gid = ?', $str);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
			$x = "UGH";
		}
		else {
			$set = array( 
				'rank'   => $resultF["position"],
				'rights' => "2"
			);
			$where = $db->quoteInto('id = ?', $resultF["gid"]);
			$db->update('authorize', $set, $where);
			$set = array( 
				'admin_id'   => $userInfo->id,
				'admin_vote' => "1",
				'admin_date' => date("Y-m-d G:i:s"),
				'admin_ip'   => $_SERVER['REMOTE_ADDR']
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('profile_app', $set, $where);

			$x = "YAY";
		}

		return $x;
	}

	function dodeny($str)
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

		$x = "UGH";

		$queryF = $db->select()
			->from('profile_app')
			->where('admin_vote = ?', '0')
			->where('gid = ?', $str);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
			$x = "UGH";
		}
		else {
			$set = array( 
				'admin_id'   => $userInfo->id,
				'admin_vote' => "2",
				'admin_date' => date("Y-m-d G:i:s"),
				'admin_ip'   => $_SERVER['REMOTE_ADDR']
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('profile_app', $set, $where);

			$x = "YAY";
		}

		return $x;
	}

}

