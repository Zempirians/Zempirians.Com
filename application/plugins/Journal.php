<?php

class Zend_Controller_Action_Helper_Journal extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function readlog($str,$flag)
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

		$queryA = $db->select()
			->from('war_log')
			->where('id > ?', "0")
			->order('defeated DESC');
		$resultA = $db->fetchAll($queryA);
		$queryA->reset();

		return $resultA;
	}

}

