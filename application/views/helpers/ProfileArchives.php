<?php

class Zend_View_Helper_ProfileArchives
{
	public function profileArchives ($gid)
	{
		$wmf_xs = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$html  = "";

		$queryF = $db->select()
			->from('archives')
			->where('gid = ?', $gid)
			->where('en = ?', '1');
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		// OUTPUT HTML SOURCE
		return $resultF;
	}

}

