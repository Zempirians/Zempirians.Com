<?php

class Zend_View_Helper_LabsList
{
	public function labsList ($str)
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
			->where('webvar = ?', $str)
			->order('title ASC');
		$resultA = $db->fetchAll($queryA);
		$queryA->reset();

		return $resultA;
	}

}
