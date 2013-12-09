<?php

class Zend_View_Helper_TicketLookup
{
	public function ticketLookup ($str)
	{
		$xray = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);


		$queryA = $db->select()
			->from('tickets')
			->where('lab_id = ?', $str);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		if (!$resultA) {
			return "1";
		} else {
			return "0";
		}

	}

}
