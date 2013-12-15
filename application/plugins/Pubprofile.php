<?php

class Zend_Controller_Action_Helper_Pubprofile extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function showme($str)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
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
			->from('profile_skills')
			->where('gid = ?', $str);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF["id"]) {
			$x = "UGH";
		}
		else {
			$x = "YAY";
		}

		return $x;
	}
}

