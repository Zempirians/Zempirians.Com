<?php

class Zend_View_Helper_WarInbox
{
	public function warInbox ($str)
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


		if ($str == "count") {
			$queryF = $db->select()
				->from('war_inbox', array("xcount"=>"COUNT(*)"))
				->where('recv_id = ?', $userInfo->id)
				->where('en = ?', "1");
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return "(" . $resultF["xcount"] . ")";
		}

		if ($str == "all") {
			$queryF = $db->select()
				->from('war_inbox')
				->where('recv_id = ?', $userInfo->id)
				->where('en = ?', "1");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if (is_numeric($str)) {
			$queryF = $db->select()
				->from('war_inbox')
				->where('send_id = ?', $userInfo->id)
				->where('reply_id = ?', $str);
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();

			if (!$resultF) {
				return "UGH";
			} else {
				return "YAY";
			}
		}

	}

}
