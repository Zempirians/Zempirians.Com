<?php

class Zend_View_Helper_BugnetList
{
	public function bugnetList ($str)
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
			->from('bugnet')
			->where('type = ?', $str);
		$resultA = $db->fetchAll($queryA);
		$queryA->reset();

		return $resultA;
	}

}
