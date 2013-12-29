<?php

class Zend_View_Helper_SabotageLookup
{
	public function SabotageLookup ($str)
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


		$queryF = $db->select()
			->from('war_sabotage')
			->where('camp_id = ?', $str)
			->where('en = ?', "1");
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();
		return $resultF;

	}

}
