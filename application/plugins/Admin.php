<?php

class Zend_Controller_Action_Helper_Admin extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function profile($str)
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$queryF = $db->select()
			->from('authorize', array("hax"=>"COUNT(*)"))
			->where('rank = ?', $str);
		$resultF = $db->fetchAll($queryF);
		$queryF->reset();

		return $resultF["hax"];
	}

	function profilelist($str)
	{
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
			case 1:
				$myvalue = "artist";
				break;
			case 2:
				$myvalue = "developer";
				break;
			case 3:
				$myvalue = "director";
				break;
			case 4:
				$myvalue = "founder";
				break;
			case 5:
				$myvalue = "irc_admin";
				break;
			case 6:
				$myvalue = "student";
				break;
			case 7:
				$myvalue = "teacher";
				break;
			case 8:
				$myvalue = "wargame_admin";
				break;
			case 9:
				$myvalue = "writer";
				break;
			default:
				$myvalue = "ugh";
				break;
		}

		if ($myvalue == "ugh") {
			$resultF = "ugh";
		}
		else {
			$queryF = $db->select()
				->from('authorize')
				->where('rank = ?', $myvalue);
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}

	function archivelist($str)
	{
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
			case 1:
				$myvalue = "1";
				break;
			case 0:
				$myvalue = "0";
				break;
			default:
				$myvalue = "ugh";
				break;
		}

		if ($myvalue == "ugh") {
			$resultF = "ugh";
		}
		else {
			$queryF = $db->select()
				->from('archives')
				->where('en = ?', $myvalue);
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}

	function curriculum($a,$name)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$x = "UGH";

		switch ($name) {
			case "view":
				$queryF = $db->select()
					->from('school_curriculum')
					->where('en >= ?', '0');
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				$x = $resultF;
				break;
			case 0:
				$set = array( 
					'admin_id'     => $userInfo->id,
					'admin_create' => date("Y-m-d G:i:s"),
					'admin_vote'   => '0',
					'en'           => '0'
				);
				$where = $db->quoteInto('id = ?', $a);
				$db->update('school_curriculum', $set, $where);
				$x = "YAY";
				break;
			case 1:
				$set = array( 
					'admin_id'     => $userInfo->id,
					'admin_create' => date("Y-m-d G:i:s"),
					'admin_vote'   => '1',
					'en'           => '1'
				);
				$where = $db->quoteInto('id = ?', $a);
				$db->update('school_curriculum', $set, $where);
				$x = "YAY";
				break;
			default:
				$x = "UGH";
				break;
		}

		return $x;
	}

	function course($a,$name)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$x = "UGH";

		switch ($name) {
			case "view":
				$queryF = $db->select()
					->from('school_course')
					->where('en >= ?', '0');
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				$x = $resultF;
				break;
			case 0:
				$set = array( 
					'admin_id'     => $userInfo->id,
					'admin_create' => date("Y-m-d G:i:s"),
					'admin_vote'   => '0',
					'en'           => '0'
				);
				$where = $db->quoteInto('id = ?', $a);
				$db->update('school_course', $set, $where);
				$x = "YAY";
				break;
			case 1:
				$set = array( 
					'admin_id'     => $userInfo->id,
					'admin_create' => date("Y-m-d G:i:s"),
					'admin_vote'   => '1',
					'en'           => '1'
				);
				$where = $db->quoteInto('id = ?', $a);
				$db->update('school_course', $set, $where);
				$x = "YAY";
				break;
			default:
				$x = "UGH";
				break;
		}

		return $x;
	}

	function lesson($a,$name)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$x = "UGH";

		switch ($name) {
			case "view":
				$queryF = $db->select()
					->from('school_lesson')
					->where('en >= ?', '0');
				$resultF = $db->fetchAll($queryF);
				$queryF->reset();
				$x = $resultF;
				break;
			case 0:
				$set = array( 
					'admin_id'     => $userInfo->id,
					'admin_create' => date("Y-m-d G:i:s"),
					'admin_vote'   => '0',
					'en'           => '0'
				);
				$where = $db->quoteInto('id = ?', $a);
				$db->update('school_lesson', $set, $where);
				$x = "YAY";
				break;
			case 1:
				$set = array( 
					'admin_id'     => $userInfo->id,
					'admin_create' => date("Y-m-d G:i:s"),
					'admin_vote'   => '1',
					'en'           => '1'
				);
				$where = $db->quoteInto('id = ?', $a);
				$db->update('school_lesson', $set, $where);
				$x = "YAY";
				break;
			default:
				$x = "UGH";
				break;
		}

		return $x;
	}











	function emailtool($xid, $xsub, $xmsg)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		switch ($xid) {
			case 0:
				$myvalue = "all";
				break;
			case 1:
				$myvalue = "artist";
				break;
			case 2:
				$myvalue = "developer";
				break;
			case 3:
				$myvalue = "director";
				break;
			case 4:
				$myvalue = "founder";
				break;
			case 5:
				$myvalue = "irc_admin";
				break;
			case 6:
				$myvalue = "student";
				break;
			case 7:
				$myvalue = "teacher";
				break;
			case 8:
				$myvalue = "war_admin";
				break;
			case 9:
				$myvalue = "writer";
				break;
			default:
				$myvalue = "UGH";
				break;
		}

		if ($myvalue == "all") {
			$queryE = $db->select()
				->from('authorize');
			$resultF = $db->fetchAll($queryE);
			$queryE->reset();

			foreach ($resultF as $result) {
				mail($result["email"], $xsub, $xmsg, "From: admin@zempirians.com");
			}
			
			return "YAY";
		}
		elseif ($myvalue == "UGH") {
			return $myvalue;
		}
		else {
			$queryE = $db->select()
				->from('authorize')
				->where('rank = ?', $myvalue);
			$resultF = $db->fetchAll($queryE);
			$queryE->reset();

			foreach ($resultF as $result) {
				mail($result["email"], $xsub, $xmsg, "From: admin@zempirians.com");
			}
			
			return "YAY";
		}
		
		
	}




	function mycampid()
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR DUPE NAMES
		$queryE = $db->select()
			->from('war_campaign')
			->where('admin = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();
		return $resultF["id"];
	}

	function teamsget($str)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR DUPE NAMES
		$queryE = $db->select()
			->from('war_teams')
			->where('campaign = ?', $str);
		$resultF = $db->fetchAll($queryE);
		$queryE->reset();
		return $resultF;
	}

	function createcamp($name,$camp)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR DUPE NAMES
		$queryE = $db->select()
			->from('war_campaign')
			->where('name = ?', $name);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {

			// CREATE CAMPAIGN
			$set = array (
				'name'    => $name,
				'created' => date("Y-m-d G:i:s"),
				'status'  => "pending",
				'admin'   => $userInfo->id
			);
			$db->insert('war_campaign', $set);

			// GET CAMPAIGN ID
			$queryE = $db->select()
				->from('war_campaign')
				->where('name = ?', $name);
			$resultG = $db->fetchRow($queryE);
			$queryE->reset();

			// ADD WAR LOG
			$set = array (
				'attackers' => "0",
				'defenders' => "0",
				'defeated'  => date("Y-m-d G:i:s"),
				'journal'   => "%ADMIN% is in neogiations over a new campaign called %CAMPAIGN% joining the network.",
				'campaign'  => $resultG["id"],
				'box'       => "0",
				'type'      => "log",
				'admin'     => $userInfo->id
			);
			$db->insert('war_log', $set);

			// SUCCESS
			return "YAY";
		}
		else { return "UGH"; } // FAIL

	}

	function createnode($local,$remote,$id)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR MASTER RIGHTS
		if ($userInfo->campaign == "2") {
			//DO INSERT
			$queryE = $db->select()
				->from('war_campaign')
				->where('id = ?', $id);
			$resultF = $db->fetchRow($queryE);
			$queryE->reset();
			// CREATE NODE
			$set = array (
				'campaign' => $id,
				'team'     => "0",
				'created'  => date("Y-m-d G:i:s"),
				'status'   => "open",
				'local'    => $local,
				'remote'   => $remote
			);
			$db->insert('war_boxes', $set);
			// ADD WAR LOG
			$set = array (
				'attackers' => "0",
				'defenders' => "0",
				'defeated'  => date("Y-m-d G:i:s"),
				'journal'   => "%ADMIN% has opened a new node on campaign - %CAMPAIGN%",
				'campaign'  => $id,
				'box'       => "0",
				'type'      => "log",
				'admin'     => $userInfo->id
			);
			$db->insert('war_log', $set);
			return "YAY";
		}

		// CHECK FOR ADMIN RIGHTS
		if ($userInfo->campaign == "1") {

			//DO CHECK FOR ADMIN OWNERSHIP
			$queryE = $db->select()
				->from('war_campaign')
				->where('id = ?', $id);
			$resultF = $db->fetchRow($queryE);
			$queryE->reset();

			if ($resultF["admin"] == $userInfo->id) {

				// CREATE NODE
				$set = array (
					'campaign' => $id,
					'team'     => "0",
					'created'  => date("Y-m-d G:i:s"),
					'status'   => "open",
					'local'    => $local,
					'remote'   => $remote
				);
				$db->insert('war_boxes', $set);

				// ADD WAR LOG
				$set = array (
					'attackers' => "0",
					'defenders' => "0",
					'defeated'  => date("Y-m-d G:i:s"),
					'journal'   => "%ADMIN% has opened a new node on campaign - %CAMPAIGN%",
					'campaign'  => $id,
					'box'       => "0",
					'type'      => "log",
					'admin'     => $userInfo->id
				);
				$db->insert('war_log', $set);

				// SUCCESS
				return "YAY";
			}
			else { return "UGH"; } // FAIL
		}

	}

	function nodeopen($id)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR RIGHTS
		$queryA = $db->select()
			->from('war_boxes')
			->where('id = ?', $id);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();
		$queryB = $db->select()
			->from('war_campaign')
			->where('id = ?', $resultA["campaign"]);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();

		if ($resultA["status"] == "pending" && $userInfo->id == $resultB["admin"]) {

			// UPDATE BOX STATUS
			$set = array( 
				'status'   => "online",
				'created'  => date("Y-m-d G:i:s")
			);
			$where = $db->quoteInto('id = ?', $id);
			$db->update('war_boxes', $set, $where);

			// ADD WAR LOG
			$set = array (
				'attackers' => "0",
				'defenders' => $resultA["team"],
				'defeated'  => date("Y-m-d G:i:s"),
				'journal'   => "%ADMIN% has allowed %DEFENDERS% to join the campaign %CAMPAIGN% on %BOX%",
				'campaign'  => $resultA["campaign"],
				'box'       => $id,
				'type'      => "log",
				'admin'     => $userInfo->id
			);
			$db->insert('war_log', $set);

			// SUCCESS
			return "YAY";
		}
		else { return "UGH"; } // FAIL

	}

	function campopen($id)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR RIGHTS
		if ($userInfo->campaign == "2") {

			// UPDATE CAMPAIGN STATUS
			$set = array( 
				'status'   => "online",
				'created'  => date("Y-m-d G:i:s")
			);
			$where = $db->quoteInto('id = ?', $id);
			$db->update('war_campaign', $set, $where);

			// ADD WAR LOG
			$set = array (
				'attackers' => "0",
				'defenders' => "0",
				'defeated'  => date("Y-m-d G:i:s"),
				'journal'   => "%ADMIN% has approved %CAMPAIGN% to join the compaign",
				'campaign'  => $id,
				'box'       => "0",
				'type'      => "log",
				'admin'     => $userInfo->id
			);
			$db->insert('war_log', $set);

			// SUCCESS
			return "YAY";
		}
		else { return "UGH"; } // FAIL

	}

	function editnode($za,$zb,$zc,$zd,$ze,$zf,$zg,$zh,$zi,$zj,$zk,$zl,$zm,$zn,$zo,$zp,$zq,$zr,$zs,$zt)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$set = array(
			'box_root_plain' => $zd,
			'box_root_hash'  => $ze,
			'sql_root_plain' => $zf,
			'sql_root_hash'  => $zg,
			'local'          => $zb,
			'remote'         => $zc,
			'box_sys'        => $zh,
			'box_ssh'        => $zi,
			'box_ssh_lport'  => $zj,
			'box_ssh_rport'  => $zk,
			'box_sql'        => $zl,
			'box_sql_lport'  => $zm,
			'box_sql_rport'  => $zn,
			'box_http'       => $zo,
			'box_http_lport' => $zp,
			'box_http_rport' => $zq,
			'box_ftp'        => $zr,
			'box_ftp_lport'  => $zs,
			'box_ftp_rport'  => $zt
		);
		$where = $db->quoteInto('id = ?', $za);
		$db->update('war_boxes', $set, $where);

		// CHECK TEAM AND CAMPAIGN
		$queryA = $db->select()
			->from('war_boxes')
			->where('id = ?', $za);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		// ADD WAR LOG
		$set = array (
			'attackers' => "0",
			'defenders' => $resultA["team"],
			'defeated'  => date("Y-m-d G:i:s"),
			'journal'   => "%ADMIN% has made changes to team %DEFENDERS% box running on %BOX% in campaign %CAMPAIGN%",
			'campaign'  => $resultA["campaign"],
			'box'       => $za,
			'type'      => "log",
			'admin'     => $userInfo->id
		);
		$db->insert('war_log', $set);

		// ADD POINTS TO TEAM
		$queryB = $db->select()
			->from('war_teams')
			->where('id = ?', $resultA["team"]);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();
		$t_points = $resultB["points"] + 1;
		$set = array(
			'points' => $t_points,
		);
		$where = $db->quoteInto('id = ?', $resultB["id"]);
		$db->update('war_teams', $set, $where);

		// ADD POINTS TO ALL ACTIVE PLAYERS
		$queryC = $db->select()
			->from('war_members')
			->where('team_id = ?', $resultA["team"])
			->where('status = ?', "active");
		$resultC = $db->fetchAll($queryC);
		$queryC->reset();
		foreach ($resultC as $player) {
			$x_points = $player["points"] + 1;
			$set = array(
				'points' => $x_points,
			);
			$where = $db->quoteInto('id = ?', $player["id"]);
			$db->update('war_members', $set, $where);
			$queryD = $db->select()
				->from('authorize')
				->where('id = ?', $player["user_id"]);
			$resultD = $db->fetchRow($queryD);
			$queryD->reset();
			$z_points = $resultD["points"] + 1;
			$set = array(
				'points' => $z_points,
			);
			$where = $db->quoteInto('id = ?', $resultD["id"]);
			$db->update('authorize', $set, $where);
		}

		// ADD POINTS TO ADMIN
		$queryE = $db->select()
			->from('war_campaign')
			->where('id = ?', $resultA["campaign"]);
		$resultE = $db->fetchRow($queryE);
		$queryE->reset();
		$queryF = $db->select()
			->from('authorize')
			->where('id = ?', $resultE["admin"]);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();
		$a_points = $resultF["points"] + 1;
		$set = array(
			'points' => $a_points,
		);
		$where = $db->quoteInto('id = ?', $resultF["id"]);
		$db->update('authorize', $set, $where);

		return "YAY";
	}

	function goteam($id)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR RIGHTS
		if ($userInfo->campaign == "2") {

			// CHECK TEAM CAMPAIGN
			$queryA = $db->select()
				->from('war_teams')
				->where('id = ?', $id);
			$resultA = $db->fetchRow($queryA);
			$queryA->reset();

			if ($resultA["campaign"] == 0) { return "UGH"; }

			// UPDATE CAMPAIGN STATUS
			$set = array( 
				'campaign'  => "0"
			);
			$where = $db->quoteInto('id = ?', $id);
			$db->update('war_teams', $set, $where);

			// ADD WAR LOG
			$set = array (
				'attackers' => "0",
				'defenders' => $id,
				'defeated'  => date("Y-m-d G:i:s"),
				'journal'   => "%ADMIN% has allowed %DEFENDERS% to spawn for queue.",
				'campaign'  => $resultA["campaign"],
				'box'       => "0",
				'type'      => "log",
				'admin'     => $userInfo->id
			);
			$db->insert('war_log', $set);

			// SUCCESS
			return "YAY";
		}
		else { return "UGH"; } // FAIL

	}

	function teamcount($camp)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// COUNT

		if ($userInfo->campaign == 2) {
			$queryA = $db->select()
				->from('war_teams', array("xnum"=>"COUNT(*)"))
				->where('campaign > ?', "0");
			$resultA = $db->fetchRow($queryA);
			$queryA->reset();
		}

		if ($userInfo->campaign == 1) {
			$queryA = $db->select()
				->from('war_teams', array("xnum"=>"COUNT(*)"))
				->where('campaign = ?', $camp);
			$resultA = $db->fetchRow($queryA);
			$queryA->reset();
		}

		return $resultA["xnum"];
	}

	function kickteam($id)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR RIGHTS
		if ($userInfo->campaign == "2") {

			// CHECK TEAM CAMPAIGN
			$queryA = $db->select()
				->from('war_teams')
				->where('id = ?', $id);
			$resultA = $db->fetchRow($queryA);
			$queryA->reset();

			if ($resultA["campaign"] == "0") { return "UGH"; }

			// UPDATE CAMPAIGN STATUS
			$set = array( 
				'campaign'  => "0"
			);
			$where = $db->quoteInto('id = ?', $id);
			$db->update('war_teams', $set, $where);

			// ADD WAR LOG
			$set = array (
				'attackers' => "0",
				'defenders' => $id,
				'defeated'  => date("Y-m-d G:i:s"),
				'journal'   => "%ADMIN% has kicked team %DEFENDERS% from campaign %CAMPAIGN%",
				'campaign'  => $resultA["campaign"],
				'box'       => "0",
				'type'      => "log",
				'admin'     => $userInfo->id
			);
			$db->insert('war_log', $set);

			// FIND ALL CONTROLLED BOXES
			$queryB = $db->select()
				->from('war_boxes')
				->where('team = ?', $id)
				->where('status != ?', "hacked")
				->where('status != ?', "dead")
				->where('status != ?', "breach");
			$resultB = $db->fetchAll($queryB);
			$queryB->reset();

			foreach ($resultB as $box) {

				// UPDATE CAMPAIGN STATUS
				$set = array( 
					'status'  => "dead",
					'created' => date("Y-m-d G:i:s"),
					'en'      => "0"
				);
				$where = $db->quoteInto('id = ?', $box["id"]);
				$db->update('war_boxes', $set, $where);

				// ADD WAR LOG
				$set = array (
					'attackers' => "0",
					'defenders' => $id,
					'defeated'  => date("Y-m-d G:i:s"),
					'journal'   => "%ADMIN% has killed %BOX% from campaign %CAMPAIGN%",
					'campaign'  => $resultA["campaign"],
					'box'       => $box["id"],
					'type'      => "log",
					'admin'     => $userInfo->id
				);
				$db->insert('war_log', $set);
			}

			// SUCCESS
			return "YAY";
		}
		else { return "UGH"; } // FAIL
	}

	function sabotage($za,$zb,$zc)
	{
		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK TEAM AND CAMPAIGN
		$queryA = $db->select()
			->from('war_boxes')
			->where('id = ?', $za);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		// ADD WAR SABOTAGE
		if ($zb == "1") {
			$set = array (
				'camp_id' => $resultA["campaign"],
				'war_id'  => $za,
				'type'    => "distro",
				'text'    => $zc,
				'created' => date("Y-m-d G:i:s"),
				'en'      => "1"
			);
			$db->insert('war_sabotage', $set);
		}
		if ($zb == "2") {
			$set = array (
				'camp_id' => $resultA["campaign"],
				'war_id'  => $za,
				'type'    => "sshd",
				'text'    => $zc,
				'created' => date("Y-m-d G:i:s"),
				'en'      => "1"
			);
			$db->insert('war_sabotage', $set);
		}
		if ($zb == "3") {
			$set = array (
				'camp_id' => $resultA["campaign"],
				'war_id'  => $za,
				'type'    => "ftpd",
				'text'    => $zc,
				'created' => date("Y-m-d G:i:s"),
				'en'      => "1"
			);
			$db->insert('war_sabotage', $set);
		}
		if ($zb == "4") {
			$set = array (
				'camp_id' => $resultA["campaign"],
				'war_id'  => $za,
				'type'    => "sqld",
				'text'    => $zc,
				'created' => date("Y-m-d G:i:s"),
				'en'      => "1"
			);
			$db->insert('war_sabotage', $set);
		}
		if ($zb == "5") {
			$set = array (
				'camp_id' => $resultA["campaign"],
				'war_id'  => $za,
				'type'    => "httpd",
				'text'    => $zc,
				'created' => date("Y-m-d G:i:s"),
				'en'      => "1"
			);
			$db->insert('war_sabotage', $set);
		}

		// ADD WAR LOG
		$set = array (
			'attackers' => "0",
			'defenders' => $resultA["team"],
			'defeated'  => date("Y-m-d G:i:s"),
			'journal'   => "%ADMIN% has sabotaged team %DEFENDERS% box running on %BOX% in campaign %CAMPAIGN%",
			'campaign'  => $resultA["campaign"],
			'box'       => $za,
			'type'      => "log",
			'admin'     => $userInfo->id
		);
		$db->insert('war_log', $set);

		// ADD POINTS TO TEAM
		$queryB = $db->select()
			->from('war_teams')
			->where('id = ?', $resultA["team"]);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();
		$t_points = $resultB["points"] + 25;
		$set = array(
			'points' => $t_points,
		);
		$where = $db->quoteInto('id = ?', $resultB["id"]);
		$db->update('war_teams', $set, $where);

		// ADD POINTS TO ALL ACTIVE PLAYERS
		$queryC = $db->select()
			->from('war_members')
			->where('team_id = ?', $resultA["team"])
			->where('status = ?', "active");
		$resultC = $db->fetchAll($queryC);
		$queryC->reset();
		foreach ($resultC as $player) {
			$x_points = $player["points"] + 25;
			$set = array(
				'points' => $x_points,
			);
			$where = $db->quoteInto('id = ?', $player["id"]);
			$db->update('war_members', $set, $where);
			$queryD = $db->select()
				->from('authorize')
				->where('id = ?', $player["user_id"]);
			$resultD = $db->fetchRow($queryD);
			$queryD->reset();
			$z_points = $resultD["points"] + 25;
			$set = array(
				'points' => $z_points,
			);
			$where = $db->quoteInto('id = ?', $resultD["id"]);
			$db->update('authorize', $set, $where);
		}

		// ADD POINTS TO ADMIN
		$queryE = $db->select()
			->from('war_campaign')
			->where('id = ?', $resultA["campaign"]);
		$resultE = $db->fetchRow($queryE);
		$queryE->reset();
		$queryF = $db->select()
			->from('authorize')
			->where('id = ?', $resultE["admin"]);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();
		$a_points = $resultF["points"] + 25;
		$set = array(
			'points' => $a_points,
		);
		$where = $db->quoteInto('id = ?', $resultF["id"]);
		$db->update('authorize', $set, $where);

		return "YAY";
	}

}

