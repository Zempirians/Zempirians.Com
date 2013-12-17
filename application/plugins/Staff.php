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
				->where('en = ?', "1");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}

}

