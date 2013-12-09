<?php

class Zend_Controller_Action_Helper_Ticket extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function report($id,$reason,$ip)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR LOG
		$queryF = $db->select()
			->from('tickets')
			->where('lab_id = ?', $id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if ($reason == "1") { $issue = "The dumb thing is offline!!!"; }
		if ($reason == "2") { $issue = "Nothing is working right, fix it!"; }
		if ($reason == "3") { $issue = "Some one hacked it! Reset it!"; }
		if ($reason == "4") { $issue = "These choices are stupid, I WILL email the issue!"; }

		if (!$resultF) {
			$set = array (
				'user_ip' => $ip,
				'issue'   => $issue,
				'created' => date("Y-m-d H:i:s"),
				'lab_id'  => $id
			);
			$db->insert('tickets', $set);

			return "YAY";
		} else {
			return "UGH";
		}

	}
}

