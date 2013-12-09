<?php

class Zend_View_Helper_WarTeams
{
	public function warTeams ($str)
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
				->from('war_teams', array("xcount"=>"COUNT(*)"))
				->where('id > ?', "0");
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["xcount"];
		}

		if ($str == "all") {
			$queryF = $db->select()
				->from('war_teams')
				->where('id > ?', "0")
				->order('points DESC');
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

	}

}
