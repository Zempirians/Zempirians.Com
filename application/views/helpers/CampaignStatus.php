<?php

class Zend_View_Helper_CampaignStatus
{
	public function campaignStatus ($str)
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

	// CHECK FOR TEAM
		$queryA = $db->select()
			->from('war_members')
			->where('team_id = ?', $str);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();
		if (!$resultA) { return "noteam"; }

	// CHECK FOR LACKS
		$queryB = $db->select()
			->from('war_members', array("x"=>"COUNT(*)"))
			->where('team_id = ?', $str);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();
		if ($resultB["x"] < 1) { return "lackingplayers"; }

	// CHECK FOR QUEUE
		$queryC = $db->select()
			->from('war_teams')
			->where('id = ?', $str)
			->where('campaign != ?', "0");
		$resultC = $db->fetchRow($queryC);
		$queryC->reset();
		if ($resultC == 0) { return "didntqueue"; }

	// CHECK FOR ACTIVE HACKING
		return "active";


	}

}
