<?php

class Zend_View_Helper_CampaignTeams
{
	public function campaignTeams ($str,$team)
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
				->from('war_boxes', array("xcount"=>"COUNT(*)"))
				->where('team = ?', $team);
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["xcount"];
		}

		if ($str == "all") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('team = ?', $team)
				->where('en = ?', "1");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

	}

}
