<?php

class Zend_View_Helper_CampaignCount
{
	public function campaignCount ($game,$camp)
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

		if ($game == "getall") {
			$queryF = $db->select()
				->from('war_campaign')
				->where('id > ?', "0")
				->where('status = ?', "online");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($game == "open") {
			$queryF = $db->select()
				->from('war_boxes', array("x"=>"COUNT(*)"))
				->where('status = ?', "open")
				->where('campaign = ?', $camp);
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["x"];
		}

		if ($game == "all") {
			$queryF = $db->select()
				->from('war_boxes', array("x"=>"COUNT(*)"))
				->where('campaign = ?', $camp);
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["x"];
		}

		if ($game == "allcamp") {
			$queryF = $db->select()
				->from('war_campaign', array("x"=>"COUNT(*)"))
				->where('id > ?', "0");
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["x"];
		}

		if ($game == "getcamp") {
			$queryF = $db->select()
				->from('war_campaign')
				->where('id > ?', "0");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($game == "adminnodes") {
			if ($userInfo->campaign == 2) {
				$queryF = $db->select()
					->from('war_boxes')
					->where('id > ?', "0")
					->where('en != ?', "0");
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				return $resultF;
			}
			if ($userInfo->campaign == 1) {
				$queryA = $db->select()
					->from('war_campaign')
					->where('admin = ?', $userInfo->id);
				$resultA = $db->fetchRow($queryA);
				$queryA->reset();
				$queryF = $db->select()
					->from('war_boxes')
					->where('campaign = ?', $resultA["id"])
					->where('en != ?', "0");
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();

				return $resultF;
			}
		}

	}

}
