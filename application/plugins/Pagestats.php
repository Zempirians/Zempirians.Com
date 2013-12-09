<?php

class Zend_Controller_Action_Helper_Pagestats extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function log($area,$view)
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
			->from('stats')
			->where('site = ?', "www.zempirians.com")
			->where('controller = ?', $area)
			->where('view = ?', $view);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF) {
			$set = array (
				'site'       => "www.zempirians.com",
				'controller' => $area,
				'view'       => $view,
				'hits'       => "1",
				'created'    => date("Y-m-d H:i:s")
			);
			$db->insert('stats', $set);

			$hits = 1;
			$created = date("Y-m-d H:i:s");
		} else {
			$created = $resultF["created"];
			$hits = $resultF["hits"];
			$hits++;

			$set = array( 
				'hits'   => $hits
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('stats', $set, $where);
		}

		$queryF = $db->select()
			->from('stats')
			->where('hits > ?', "0");
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		$total = 0;

		foreach ($resultF as $resultx) {
			$total = $total + $resultx["hits"];
		}

		$queryF = $db->select()
			->from('stats')
			->where('controller = ?', "shield")
			->where('view = ?', "trap");
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF) {
			$attack = 0;
		} else {
			$attack = $resultF["hits"];
		}

		// CHECK FOR UNIQUES
		$host = $_SERVER["REMOTE_ADDR"];
		$queryF = $db->select()
			->from('visitors')
			->where('ip = ?', $host);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF) {
			$set = array (
				'ip'      => $host,
				'first'   => date("Y-m-d H:i:s"),
				'last'    => date("Y-m-d H:i:s"),
				'hits'    => "1"
			);
			$db->insert('visitors', $set);
		} else {
			$xhits = $resultF["hits"];
			$xhits = $xhits + 1;

			$set = array( 
				'last'   => date("Y-m-d H:i:s"),
				'hits'   => $xhits
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('visitors', $set, $where);
		}

		// COUNT UNIQUES
		$queryF = $db->select()
			->from('visitors', array("hax"=>"COUNT(*)"))
			->where('id > ?', "0");
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();
		$unique = $resultF["hax"];

		$percA = ($attack / $total) * 100;
		$perc_attack = number_format($percA, 0);

		$percH = ($hits / $total) * 100;
		$perc_hits = number_format($percH, 0);

		$percT_a = $total - $attack;
		$percT_b = $percT_a / $total;
		$percT_c = $percT_b * 100;
		$perc_total = number_format($percT_c, 0);

		//return ".<br> Page accessed " . $hits . " times (" . $perc_hits . "%).<br> Website attacked " . $attack . " times (" . $perc_attack . "%).<br> Website accessed " . $total . " times (" . $perc_total . "%).<br> Stats since " . $created . ".";
		//return ".<br> Page accessed " . $hits . " times (" . $perc_hits . "%).<br> Website accessed " . $total . " times (" . $perc_total . "%).<br> Stats since " . $created . ".";
		return ". Page accessed " . $hits . " times (" . $perc_hits . "%). Website accessed " . $total . " times (" . $unique . "). Stats since " . $created . ".";
	}

	function hacked($host)
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
			->from('security')
			->where('site = ?', "www.zempirians.com")
			->where('ip = ?', $host);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF) {
			$set = array (
				'site'    => "www.zempirians.com",
				'ip'      => $host,
				'first'   => date("Y-m-d H:i:s"),
				'last'    => date("Y-m-d H:i:s"),
				'hits'    => "1"
			);
			$db->insert('security', $set);
		} else {
			$xhits = $resultF["hits"];
			$xhits = $xhits + 1;

			$set = array( 
				'last'   => date("Y-m-d H:i:s"),
				'hits'   => $xhits
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('security', $set, $where);
		}

	}

	function errors($host)
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
			->from('errors')
			->where('site = ?', "www.zempirians.com")
			->where('ip = ?', $host);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF) {
			$set = array (
				'site'    => "www.zempirians.com",
				'ip'      => $host,
				'first'   => date("Y-m-d H:i:s"),
				'last'    => date("Y-m-d H:i:s"),
				'hits'    => "1"
			);
			$db->insert('errors', $set);
		} else {
			$xhits = $resultF["hits"];
			$xhits = $xhits + 1;

			$set = array( 
				'last'   => date("Y-m-d H:i:s"),
				'hits'   => $xhits
			);
			$where = $db->quoteInto('id = ?', $resultF["id"]);
			$db->update('errors', $set, $where);
		}


	}

}

