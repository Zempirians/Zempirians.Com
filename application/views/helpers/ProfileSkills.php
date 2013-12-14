<?php

class Zend_View_Helper_ProfileSkills
{
	public function profileSkills ($str,$gid)
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

		// 0 = Skills for display object
		if ($str == "0") {			
			$queryF = $db->select()
				->from('profile_skills')
				->where('place = ?', $str)
				->where('gid = ?', $gid)
				->where('en = ?', '1');
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		// 1 = Credentials for display object
		if ($str == "1") {			
			$queryF = $db->select()
				->from('profile_skills')
				->where('place = ?', $str)
				->where('gid = ?', $gid)
				->where('en = ?', '1');
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		// 2 = Experience for display object
		if ($str == "2") {			
			$queryF = $db->select()
				->from('profile_skills')
				->where('place = ?', $str)
				->where('gid = ?', $gid)
				->where('en = ?', '1');
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		// 3 = Interests for display object
		if ($str == "3") {			
			$queryF = $db->select()
				->from('profile_skills')
				->where('place = ?', $str)
				->where('gid = ?', $gid)
				->where('en = ?', '1');
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		// OUTPUT HTML SOURCE
		return $resultF;
	}

}

