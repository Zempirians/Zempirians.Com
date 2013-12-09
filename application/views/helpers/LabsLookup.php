<?php

class Zend_View_Helper_LabsLookup
{
	public function labsLookup ($str)
	{

		$xray = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);


		$queryA = $db->select()
			->from('labs')
			->where('id = ?', $str);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		return $resultA;

	}

}
