<?php

class Zend_Controller_Action_Helper_Admin extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function profile($str)
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
			->from('authorize', array("hax"=>"COUNT(*)"))
			->where('rank = ?', $str);
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		return $resultF["hax"];
	}

	function profilelist($str)
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
				$myvalue = "artist";
				break;
			case 2:
				$myvalue = "developer";
				break;
			case 3:
				$myvalue = "director";
				break;
			case 4:
				$myvalue = "founder";
				break;
			case 5:
				$myvalue = "irc_admin";
				break;
			case 6:
				$myvalue = "student";
				break;
			case 7:
				$myvalue = "teacher";
				break;
			case 8:
				$myvalue = "wargame_admin";
				break;
			case 9:
				$myvalue = "writer";
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
				->from('authorize')
				->where('rank = ?', $myvalue);
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}

	function archivelist($str)
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
				$myvalue = "1";
				break;
			case 0:
				$myvalue = "0";
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
				->from('archives')
				->where('en = ?', $myvalue);
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}
}

