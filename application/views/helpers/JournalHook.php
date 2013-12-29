<?php

class Zend_View_Helper_JournalHook
{
	public function journalHook ($str)
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

		// LOG
		$queryA = $db->select()
			->from('war_log')
			->where('id = ?', $str);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();
		$log = $resultA["journal"];

		// %ADMIN% FIX
		if ($resultA["admin"] != "0") {
			$queryB = $db->select()
				->from('authorize')
				->where('id = ?', $resultA["admin"]);
			$resultB = $db->fetchRow($queryB);
			$queryB->reset();
			$fix = "<strong>" . $resultB["handle"] ."</strong>";
			$log = str_replace("%ADMIN%", $fix, $log);
		}

		// %CAMPAIGN% FIX
		if ($resultA["campaign"] != "0") {
			$queryC = $db->select()
				->from('war_campaign')
				->where('id = ?', $resultA["campaign"]);
			$resultC = $db->fetchRow($queryC);
			$queryC->reset();
			$fix = "<strong>" . $resultC["name"] ."</strong>";
			$log = str_replace("%CAMPAIGN%", $fix, $log);
		}

		// %DEFENDERS% FIX
		if ($resultA["defenders"] != "0") {
			$queryD = $db->select()
				->from('war_teams')
				->where('id = ?', $resultA["defenders"]);
			$resultD = $db->fetchRow($queryD);
			$queryD->reset();
			$fix = "<strong>" . $resultD["name"] ."</strong>";
			$log = str_replace("%DEFENDERS%", $fix, $log);
		}

		// %BOX% FIX
		if ($resultA["box"] != "0") {
			$fix = "<strong>Node " . $resultA["box"] ."</strong>";
			$log = str_replace("%BOX%", $fix, $log);
		}

		// %ATTACKERS% FIX
		if ($resultA["attackers"] != "0") {
			$queryE = $db->select()
				->from('war_teams')
				->where('id = ?', $resultA["defenders"]);
			$resultE = $db->fetchRow($queryE);
			$queryE->reset();
			$fix = "<strong>" . $resultE["name"] ."</strong>";
			$log = str_replace("%ATTACKERS%", $fix, $log);
		}

		return $log;

	}

}
