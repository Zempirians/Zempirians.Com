<?php

class Zend_View_Helper_AcademyCourse
{
	public function academyCourse ($type,$str)
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

		switch ($type) {
			case "lookup":
				$queryF = $db->select()
					->from('school_course')
					->where('id = ?', $str);
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				$answer = $resultF;
				break;
			case "obtain":
				$queryF = $db->select()
					->from('school_course')
					->where('pid = ?', $str)
					->where('en = ?', "1");
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				$answer = $resultF;
				break;
			case "status":
				$queryF = $db->select()
					->from('school_course')
					->where('id = ?', $str);
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();
				if ($resultF["admin_id"] == "0") {
					$answer = "Pending";
				}
				elseif ($resultF["admin_vote"] == "1") {
					$answer = "Approved";
				}
				elseif ($resultF["admin_vote"] == "0") {
					$answer = "Denied";
				}
				break;
		}

		// OUTPUT HTML SOURCE
		return $answer;
	}

}

