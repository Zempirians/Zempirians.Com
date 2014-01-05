<?php

class Zend_View_Helper_AdminAcademy
{
	public function adminAcademy ($str)
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
			case "curriculumtotal":
				$queryF = $db->select()
					->from('school_curriculum', array("hax"=>"COUNT(*)"))
					->where('en = ?', '1');
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				$html = $resultF["hax"];
				break;
			case "coursetotal":
				$queryF = $db->select()
					->from('school_course', array("hax"=>"COUNT(*)"))
					->where('en = ?', '1');
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				$html = $resultF["hax"];
				break;
			case "lessontotal":
				$queryF = $db->select()
					->from('school_lesson', array("hax"=>"COUNT(*)"))
					->where('en = ?', '1');
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				$html = $resultF["hax"];
				break;
			case "dead":
				$queryF = $db->select()
					->from('archives', array("hax"=>"COUNT(*)"))
					->where('en = ?', '0');
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				$html = $resultF["hax"];
				break;
			default:
				$queryF = $db->select()
					->from('archives', array("hax"=>"COUNT(*)"))
					->where('en = ?', '1');
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				$html = $resultF["hax"];
				break;
		}

		// OUTPUT HTML SOURCE
		return $html;
	}

}

