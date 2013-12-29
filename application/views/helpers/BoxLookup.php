<?php

class Zend_View_Helper_BoxLookup
{
	public function boxLookup ($flag,$str)
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

		if ($flag == "box") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('id = ?', $str);
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($flag == "box_online") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('campaign = ?', $str)
				->where('status = ?', "online");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($flag == "box_pending") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('campaign = ?', $str)
				->where('status = ?', "pending");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($flag == "box_open") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('campaign = ?', $str)
				->where('status = ?', "open");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($flag == "box_hacked") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('campaign = ?', $str)
				->where('status = ?', "hacked");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}

		if ($flag == "box_breach") {
			$queryF = $db->select()
				->from('war_boxes')
				->where('campaign = ?', $str)
				->where('status = ?', "breach");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
			return $resultF;
		}
	}

}
