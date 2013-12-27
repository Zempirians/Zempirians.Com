<?php

class Zend_View_Helper_WarInboxreply
{
	public function warInboxreply ($str)
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
			->from('war_inbox')
			->where('send_id = ?', $userInfo->id)
			->where('reply_id = ?', $str);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF) {
			return "UGH";
		} else {
			return $resultF;
		}

	}

}
