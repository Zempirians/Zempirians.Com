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

	function oldapp($str)
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
			->where('admin_vote > ?', '0');
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		return $resultF["hax"];
	}

}

