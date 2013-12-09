<?php

class Zend_View_Helper_TicketList
{
	public function ticketList ($str)
	{
		$xray = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);


		if ($str == "issues") {
			$queryA = $db->select()
				->from('tickets')
				->where('id > ?', "0")
				->order('created DESC');
			$resultA = $db->fetchAll($queryA);
			$queryA->reset();

			return $resultA;
		}

		if ($str == "solutions") {
			$queryA = $db->select()
				->from('tickets_old')
				->where('id > ?', "0")
				->order('created DESC');
			$resultA = $db->fetchAll($queryA);
			$queryA->reset();

			return $resultA;
		}


	}

}
