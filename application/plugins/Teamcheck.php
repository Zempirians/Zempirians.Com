<?php

class Zend_Controller_Action_Helper_Teamcheck extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function whoami($str)
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

		$queryE = $db->select()
			->from('war_teams')
			->where('admin_id = ?', $str);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		$queryF = $db->select()
			->from('war_members')
			->where('user_id = ?', $str);
		$resultG = $db->fetchRow($queryF);
		$queryF->reset();

		if (!$resultF && !$resultG) {
			return "UGH";
		} else {
			return "YAY";
		}
	}

	function create($str)
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

		$queryE = $db->select()
			->from('war_teams')
			->where('name = ?', $str);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {

		// CREATE TEAM ENTRY
			$rancod = mt_rand();

			$set = array (
				'name'     => $str,
				'admin_id' => $userInfo->id,
				'created'  => date("Y-m-d G:i:s"),
				'code'     => $rancod,
				'points'   => '0'
			);
			$db->insert('war_teams', $set);

		// GRAB ENTRY
			$queryA = $db->select()
				->from('war_teams')
				->where('admin_id = ?', $userInfo->id);
			$resultA = $db->fetchRow($queryA);
			$queryA->reset();

		// CREATE MEMBER
			$set = array (
				'team_id'  => $resultA["id"],
				'points'   => '0',
				'user_id'  => $userInfo->id,
				'code'     => $rancod,
				'status'   => "active",
				'created'  => date("Y-m-d G:i:s")
			);
			$db->insert('war_members', $set);

			return "YAY";

		} else {
			return "UGH";
		}
	}

	function lookup($str)
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

		$queryE = $db->select()
			->from('war_members')
			->where('user_id = ?', $str);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		$queryZ = $db->select()
			->from('war_teams')
			->where('id = ?', $resultF["team_id"]);
		$resultZ = $db->fetchRow($queryZ);
		$queryZ->reset();

		return $resultZ;
	}

	function member($str)
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

		$queryE = $db->select()
			->from('war_members')
			->where('user_id = ?', $str);
		$resultZ = $db->fetchRow($queryE);
		$queryE->reset();

		return $resultZ;
	}

	function prereq($str)
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

		$queryE = $db->select()
			->from('war_members', array("xcount"=>"COUNT(*)"))
			->where('team_id = ?', $str);
		$resultZ = $db->fetchRow($queryE);
		$queryE->reset();

		if ($resultZ["xcount"] < 5) {
			return "UGH";
		} else {
			return "YAY";
		}
	}

	function precamp($str)
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

		$queryE = $db->select()
			->from('war_boxes')
			->where('team = ?', $str)
			->where('status > ?', "hacked");
		$resultZ = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultZ) {
			return "UGH";
		} else {
			return "YAY";
		}
	}

	function campstate($str)
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

		$queryE = $db->select()
			->from('war_boxes')
			->where('team = ?', $str);
		$resultZ = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultZ) {
			return "UGH";
		} else {
			return "YAY";
		}
	}


	function add($str)
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

		$queryA = $db->select()
			->from('war_teams')
			->where('admin_id = ?', $userInfo->id);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

	// YOU ARE NOT ADMIN
		if (!$resultA) { return "UGH"; }

	// USER ACCOUNT DON'T EXIST	
		$queryE = $db->select()
			->from('authorize')
			->where('email = ?', $str);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();
		if (!$resultF) { return "UGH"; }

	// EMAIL EXISTS AND IS NOT ON A TEAM OR LEADER
		$queryZ = $db->select()
			->from('war_teams')
			->where('admin_id = ?', $resultF["id"]);
		$resultZ = $db->fetchRow($queryZ);
		$queryZ->reset();

		$queryB = $db->select()
			->from('war_members')
			->where('user_id = ?', $resultF["id"]);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();

		if (!$resultZ && !$resultB) {

		// SEND A MESSAGE!
			$note = "You have been invited to join team \"". $resultA["name"] ."\".<br><br>You can answer the invite by viewing the <a href=\"/team/board\">Team Board</a>.";
 			$set = array( 
				'send_id' => $userInfo->id,
				'recv_id' => $resultF["id"],
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'created' => date("Y-m-d G:i:s"),
				'note'    => $note,
				'en'      => "1",
				'subject' => "Team Invitation"
			);
			$db->insert('war_inbox', $set);

			$set = array (
				'team_id'  => $resultA["id"],
				'points'   => '0',
				'user_id'  => $resultF["id"],
				'code'     => $resultA["code"],
				'status'   => "pending",
				'created'  => date("Y-m-d G:i:s")
			);
			$db->insert('war_members', $set);
			// MEMBER HAS JOINED THIS TEAM
			return "YAY";
		} else {
			// MEMBER IS ALREADY IN A TEAM
			return "UGH";
		}
	}

	function join($str)
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

	// CHECK TEAM
		$queryD = $db->select()
			->from('war_teams')
			->where('id = ?', $str);
		$resultD = $db->fetchRow($queryD);
		$queryD->reset();

	// CHECK MEMBER
		$queryE = $db->select()
			->from('war_members')
			->where('user_id = ?', $userInfo->id)
			->where('team_id = ?', $str)
			->where('code = ?', $resultD["code"])
			->where('status = ?', "pending");
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {
			return "UGH";
		} else {
			$set = array( 
				'status'   => "active"
			);
			$where = $db->quoteInto('user_id = ?', $userInfo->id);
			$db->update('war_members', $set, $where);

		// SEND A MESSAGE!
			$note = "I have decided to accept your team invite. Thank you.";
 			$set = array( 
				'send_id' => $userInfo->id,
				'recv_id' => $resultD["admin_id"],
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'created' => date("Y-m-d G:i:s"),
				'note'    => $note,
				'en'      => "1",
				'subject' => "RE: Team Invitation"
			);
			$db->insert('war_inbox', $set);

			return "YAY";
		}
	}

	function deny($str)
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

	// CHECK TEAM
		$queryD = $db->select()
			->from('war_teams')
			->where('id = ?', $str);
		$resultD = $db->fetchRow($queryD);
		$queryD->reset();

	// CHECK MEMBER
		$queryE = $db->select()
			->from('war_members')
			->where('user_id = ?', $userInfo->id)
			->where('team_id = ?', $str)
			->where('code = ?', $resultD["code"])
			->where('status = ?', "pending");
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {
			return "UGH";
		} else {

			$set =	$db->quoteInto('user_id = ?', $userInfo->id);
			$db->delete('war_members', $set);

		// SEND A MESSAGE!
			$note = "I have decided to deny your team invite. Sorry.";
 			$set = array( 
				'send_id' => $userInfo->id,
				'recv_id' => $resultD["admin_id"],
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'created' => date("Y-m-d G:i:s"),
				'note'    => $note,
				'en'      => "1",
				'subject' => "RE: Team Invitation"
			);
			$db->insert('war_inbox', $set);

			return "YAY";
		}
	}

	function kick($str)
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

		$queryD = $db->select()
			->from('war_teams')
			->where('admin_id = ?', $userInfo->id);
		$resultD = $db->fetchRow($queryD);
		$queryD->reset();

		// ARE YOU TEAM LEADER
		if (!$resultD) {
			return "UGH";
		} else {
			// ARE YOU KICKING YOURSELF
			if ($resultD["admin_id"] == $str) {
				return "UGH";
			} else {
				// CHECK MEMBER
				$queryE = $db->select()
					->from('war_members')
					->where('user_id = ?', $str)
					->where('team_id = ?', $resultD["id"]);
				$resultE = $db->fetchRow($queryE);
				$queryE->reset();
				// IS THIS YOUR MEMBER
				if (!$resultE) {
					return "UGH";
				} else {
					// GRAB MEMBER POINTS
					$queryF = $db->select()
						->from('authorize')
						->where('id = ?', $str);
					$resultF = $db->fetchRow($queryF);
					$queryF->reset();
					// ADD POINTS
					$points = $resultF["points"] + $resultE["points"];
					// UPDATE POINTS
					$set = array( 
						'points'   => $points
					);
					$where = $db->quoteInto('id = ?', $str);
					$db->update('authorize', $set, $where);
					// DELETE FROM MEMBERS
					$set =	$db->quoteInto('user_id = ?', $str);
					$db->delete('war_members', $set);
					// SEND A MESSAGE!
					$note = "You have been removed from the team. Sorry.";
		 			$set = array( 
						'send_id' => $userInfo->id,
						'recv_id' => $str,
						'ip'      => $_SERVER['REMOTE_ADDR'],
						'created' => date("Y-m-d G:i:s"),
						'note'    => $note,
						'en'      => "1",
						'subject' => "Team Removal"
					);
					$db->insert('war_inbox', $set);
					// CONFIRM DELETE
					return "YAY";
				}
			}
		}
	}

	function queue($id,$camp)
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

		// VERIFY LEADER
		$queryE = $db->select()
			->from('war_teams')
			->where('id = ?', $id)
			->where('admin_id = ?', $userInfo->id);
		$resultZ = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultZ) {
			return "UGH";
		} else {
			// CHECK FOR OPEN NODE
			$queryE = $db->select()
				->from('war_boxes')
				->where('status = ?', "open");
			$resultA = $db->fetchRow($queryE);
			$queryE->reset();

			if (!$resultA) {
				return "UGH";
			} else {
				// INSERT INTO OPEN
				$set = array( 
					'team'    => $id,
					'created' => date("Y-m-d G:i:s"),
					'status'  => "pending"
				);
				$where = $db->quoteInto('id = ?', $resultA["id"]);
				$db->update('war_boxes', $set, $where);

				// UPDATE TEAM FOR CAMPAIGN
				$set = array( 
					'campaign' => $camp
				);
				$where = $db->quoteInto('id = ?', $resultZ["id"]);
				$db->update('war_teams', $set, $where);

				// FIND CAMPAIGN ADMIN
				$queryE = $db->select()
					->from('war_campaign')
					->where('id = ?', $resultA["campaign"]);
				$resultB = $db->fetchRow($queryE);
				$queryE->reset();

				// SEND A MESSAGE!
				$note = "I am ready to begin setting up my node " . $resultA["id"] . " for ip " . $resultA["local"] . ", please confirm. Ask me what operating system I want.";
	 			$set = array( 
					'send_id' => $userInfo->id,
					'recv_id' => $resultB["admin"],
					'ip'      => $_SERVER['REMOTE_ADDR'],
					'created' => date("Y-m-d G:i:s"),
					'note'    => $note,
					'en'      => "1",
					'subject' => "New Team for Campaign"
				);
				$db->insert('war_inbox', $set);

				return "YAY";
			}
		}
	}


}

