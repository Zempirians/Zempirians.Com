<?php

class Zend_View_Helper_WarInboxread
{
	public function warInboxread ($str)
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

		// MARKED AS READ NOW
		$set = array( 
			'read_en'      => "1",
			'read_created' => date("Y-m-d G:i:s")
		);
		$where = $db->quoteInto('id = ?', $str);
		$db->update('war_inbox', $set, $where);

		// GET MESSAGE
		$queryF = $db->select()
			->from('war_inbox')
			->where('id = ?', $str)
			->where('recv_id = ?', $userInfo->id)
			->where('en = ?', "1");
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();
		return $resultF;
	}

}
