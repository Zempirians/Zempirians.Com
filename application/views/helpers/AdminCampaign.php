<?php

class Zend_View_Helper_AdminCampaign
{
	public function adminCampaign ($str)
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

		if ($str == "showcamps") {

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

			if ($userInfo->campaign == "2") {
				$queryE = $db->select()
					->from('war_campaign')
					->where('id > ?', "0");
				$resultG = $db->fetchAll($queryE);
				$queryE->reset();
				return $resultG;
			}
			if ($userInfo->campaign == "1") {
				$queryE = $db->select()
					->from('war_campaign')
					->where('admin = ?', $userInfo->id);
				$resultG = $db->fetchAll($queryE);
				$queryE->reset();
				return $resultG;
			}
		}

	}

}
