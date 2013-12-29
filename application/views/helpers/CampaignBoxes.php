<?php

class Zend_View_Helper_CampaignBoxes
{
	public function campaignBoxes ($str)
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
				->where('id > ?', "0");
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["xcount"];
		}

		if ($str == "open") {
			$queryF = $db->select()
				->from('war_boxes', array("xcount"=>"COUNT(*)"))
				->where('status = ?', "open");
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF["xcount"];
		}

		if ($str == "all") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('id > ?', "0");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if (is_numeric($str)) {
			$queryB = $db->select()
				->from('war_boxes')
				->where('status != ?', "hacked")
				->where('status != ?', "open");
			$resultB = $db->fetchAll($queryB);
			$queryB->reset();
			return $resultB;
		}

	}

}
