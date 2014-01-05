<?php

class Zend_View_Helper_AcademyList
{
	public function academyList ($str)
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

		switch ($str) {
			case "curriculum":
				$queryF = $db->select()
					->from('school_curriculum')
					->where('admin_vote = ?', '1')
					->where('en = ?', '1');
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				$answer = $resultF;
				break;
			case "course":
				$queryF = $db->select()
					->from('school_course')
					->where('admin_vote = ?', '1')
					->where('en = ?', '1');
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				$answer = $resultF;
				break;
		}

		// OUTPUT HTML SOURCE
		return $answer;
	}

}

