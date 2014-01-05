<?php

class Zend_View_Helper_StaffAcademy
{
	public function staffAcademy ($str)
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
	
		switch ($str) {
			case 1:
				$myvalue = "school_curriculum";
				break;
			case 2:
				$myvalue = "school_course";
				break;
			case 3:
				$myvalue = "school_lesson";
				break;
		}

		$queryF = $db->select()
			->from($myvalue, array("hax"=>"COUNT(*)"))
			->where('en = ?', '1')
			->where('admin_vote = ?', '1');
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		$html = $resultF["hax"];

		// OUTPUT HTML SOURCE
		return $html;
	}

}

