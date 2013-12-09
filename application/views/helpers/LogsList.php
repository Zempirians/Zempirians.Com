<?php

class Zend_View_Helper_LogsList
{
	public function logsList ($str)
	{
		$xray = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);


		if ($str == "attacks") {
			$queryA = $db->select()
				->from('security')
				->where('id > ?', "0")
				->where('en = ?', "1")
				->order('last DESC');
			$resultA = $db->fetchAll($queryA);
			$queryA->reset();

			return $resultA;
		}

		if ($str == "errors") {
			$queryA = $db->select()
				->from('errors')
				->where('id > ?', "0")
				->where('en = ?', "1")
				->order('last DESC');
			$resultA = $db->fetchAll($queryA);
			$queryA->reset();

			return $resultA;
		}

		if ($str == "links") {
			$queryA = $db->select()
				->from('stats')
				->where('id > ?', "0")
				->where('en = ?', "1")
				->order('hits DESC');
			$resultA = $db->fetchAll($queryA);
			$queryA->reset();

			return $resultA;
		}

		if ($str == "uniques") {
			$queryA = $db->select()
				->from('visitors')
				->where('id > ?', "0")
				->where('en = ?', "1")
				->order('hits DESC');
			$resultA = $db->fetchAll($queryA);
			$queryA->reset();

			return $resultA;
		}

	}

}
