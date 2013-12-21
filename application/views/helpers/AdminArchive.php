<?php

class Zend_View_Helper_AdminArchive
{
	public function adminArchive ($str)
	{
		$wmf_xs = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$html  = "";

		if ($str == "total") {
			$queryF = $db->select()
				->from('archives', array("hax"=>"COUNT(*)"))
				->where('en = ?', '1');
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
	
			$html = $resultF["hax"];
		}
		elseif ($str == "dead") {
			$queryF = $db->select()
				->from('archives', array("hax"=>"COUNT(*)"))
				->where('en = ?', '0');
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
	
			$html = $resultF["hax"];
		}
		else {
			$queryF = $db->select()
				->from('archives', array("hax"=>"COUNT(*)"))
				->where('en = ?', '1');
			$resultF = $db->fetchRow($queryF);
			$queryF->reset();
	
			$html = $resultF["hax"];
		}

		// OUTPUT HTML SOURCE
		return $html;
	}

}

