<?php

class Zend_View_Helper_WarInboxlog
{
	public function warInboxlog ($str)
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

		$queryB = $db->select()
			->from('war_inbox')
			->where('send_id = ?', $str)
			->where('recv_id = ?', $userInfo->id)
			->orwhere('send_id = ?', $userInfo->id)
			->where('recv_id = ?', $str);
		$resultB = $db->fetchAll($queryB);
		$queryB->reset();

		return $resultB;
	}

}
