<?php

class Zend_Controller_Action_Helper_War extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function getcampid($str)
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

		$queryA = $db->select()
			->from('war_members')
			->where('user_id = ?', $str);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		$queryC = $db->select()
			->from('war_boxes')
			->where('team = ?', $resultA["team_id"])
			->where('status > ?', "hacked");
		$resultC = $db->fetchRow($queryC);
		$queryC->reset();

		return $resultC["campaign"];
	}

	function hack($node,$opt,$ans)
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();

		$wmf_ns   = new Zend_Session_Namespace('SPLOIT');
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// OBTAIN BOX ROW
		$queryA = $db->select()
			->from('war_boxes')
			->where('id = ?', $node);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		if ($resultA["status"] != "online") { return "UGH"; }

		// GRAB TEAM ID  - POINTS
		$queryB = $db->select()
			->from('war_members')
			->where('user_id = ?', $userInfo->id);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();

		// DONT HACK YOUR OWN BOXES
		if ($resultB["team_id"] == $resultA["team"]) { return "UGH"; }

		// LOOKUP TEAM - POINTS
		$queryD = $db->select()
			->from('war_teams')
			->where('id = ?', $resultB["team_id"]);
		$resultD = $db->fetchRow($queryD);
		$queryD->reset();

		// LOOKUP CAMPAIGN ADMIN - ID MAIL
		$queryE = $db->select()
			->from('war_campaign')
			->where('id = ?', $resultA["campaign"]);
		$resultE = $db->fetchRow($queryE);
		$queryE->reset();

		// LOOKUP USER - GLOBAL POINTS
		$queryF = $db->select()
			->from('authorize')
			->where('id = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		// SQL HASH ROOT PASSWORD
		if ($opt == "10") {
			if ($ans == $resultA["sql_root_hash"]) {
				// MARK BOX AS BREACHED, HACKED WHEN CONFIRMED
				$set = array( 
					'status'   => "breach",
					'created'  => date("Y-m-d G:i:s"),
					'attack'   => $resultB["team_id"]
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);

				// WAR LOG
				$journal = "%ATTACKERS% has breached %DEFENDERS% on %CAMPAIGN% for node %BOX% by providing the encrypted sql root password";
				$set = array (
					'attackers' => $resultB["team_id"],
					'defenders' => $resultA["team"],
					'defeated'  => date("Y-m-d G:i:s"),
					'journal'   => $journal,
					'campaign'  => $resultA["campaign"],
					'box'       => $node,
					'type'      => "battle",
					'admin'     => "0"
				);
				$db->insert('war_log', $set);

				// ADD POINTS TO TEAM AND PLAYER

				$mpoints = $resultB["points"] + 10;
				$set = array( 
					'points'   => $mpoints
				);
				$where = $db->quoteInto('user_id = ?', $userInfo->id);
				$db->update('war_members', $set, $where);
				$tpoints = $resultD["points"] + 10;

				$set = array( 
					'points'   => $tpoints
				);
				$where = $db->quoteInto('id = ?', $resultB["team_id"]);
				$db->update('war_teams', $set, $where);

				// INFORM CAMPAIGN ADMIN OF THIS
				$mail_to   = $resultE["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Node " . $node . " Hacked";
				$mail_note = "Node was defeated by hash sql root password";
	 			$set = array( 
					'send_id' => $mail_from,
					'recv_id' => $mail_to,
					'ip'      => $_SERVER['REMOTE_ADDR'],
					'created' => date("Y-m-d G:i:s"),
					'note'    => $mail_note,
					'en'      => "1",
					'subject' => $mail_subj
				);
				$db->insert('war_inbox', $set);

				// MAKE SURE WE GLOBAL POINT
				$upoints = $resultF["points"] + 10;
				$set = array( 
					'points'   => $upoints
				);
				$where = $db->quoteInto('id = ?', $userInfo->id);
				$db->update('authorize', $set, $where);

				// SUCCESS
				return "YAY";
			}
			else { return "UGH"; } // FAIL
		}

		// BOX HASH ROOT PASSWORD
		if ($opt == "20") {
			if ($ans == $resultA["sql_root_hash"]) {
				// MARK BOX AS BREACHED, HACKED WHEN CONFIRMED
				$set = array( 
					'status'   => "breach",
					'created'  => date("Y-m-d G:i:s"),
					'attack'   => $resultB["team_id"]
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);

				// WAR LOG
				$journal = "%ATTACKERS% has breached %DEFENDERS% on %CAMPAIGN% for node %BOX% by providing the system encrypted root password";
				$set = array (
					'attackers' => $resultB["team_id"],
					'defenders' => $resultA["team"],
					'defeated'  => date("Y-m-d G:i:s"),
					'journal'   => $journal,
					'campaign'  => $resultA["campaign"],
					'box'       => $node,
					'type'      => "battle",
					'admin'     => "0"
				);
				$db->insert('war_log', $set);

				// ADD POINTS TO TEAM AND PLAYER
				$mpoints = $resultB["points"] + 20;
				$set = array( 
					'points'   => $mpoints
				);
				$where = $db->quoteInto('user_id = ?', $userInfo->id);
				$db->update('war_members', $set, $where);
				$tpoints = $resultD["points"] + 20;
				$set = array( 
					'points'   => $tpoints
				);
				$where = $db->quoteInto('id = ?', $resultB["team_id"]);
				$db->update('war_teams', $set, $where);

				// INFORM CAMPAIGN ADMIN OF THIS
				$mail_to   = $resultE["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Node " . $node . " Hacked";
				$mail_note = "Node was defeated by encrypted system root password";
	 			$set = array( 
					'send_id' => $mail_from,
					'recv_id' => $mail_to,
					'ip'      => $_SERVER['REMOTE_ADDR'],
					'created' => date("Y-m-d G:i:s"),
					'note'    => $mail_note,
					'en'      => "1",
					'subject' => $mail_subj
				);
				$db->insert('war_inbox', $set);

				// MAKE SURE WE GLOBAL POINT
				$upoints = $resultF["points"] + 20;
				$set = array( 
					'points'   => $upoints
				);
				$where = $db->quoteInto('id = ?', $userInfo->id);
				$db->update('authorize', $set, $where);

				// SUCCESS
				return "YAY";
			}
			else { return "UGH"; } // FAIL
		}

		// SQL PLAIN ROOT PASSWORD
		if ($opt == "30") {
			if ($ans == $resultA["sql_root_hash"]) {
				// MARK BOX AS BREACHED, HACKED WHEN CONFIRMED
				$set = array( 
					'status'   => "breach",
					'created'  => date("Y-m-d G:i:s"),
					'attack'   => $resultB["team_id"]
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);

				// WAR LOG
				$journal = "%ATTACKERS% has breached %DEFENDERS% on %CAMPAIGN% for node %BOX% by providing the plaintext sql root password";
				$set = array (
					'attackers' => $resultB["team_id"],
					'defenders' => $resultA["team"],
					'defeated'  => date("Y-m-d G:i:s"),
					'journal'   => $journal,
					'campaign'  => $resultA["campaign"],
					'box'       => $node,
					'type'      => "battle",
					'admin'     => "0"
				);
				$db->insert('war_log', $set);

				// ADD POINTS TO TEAM AND PLAYER
				$mpoints = $resultB["points"] + 30;
				$set = array( 
					'points'   => $mpoints
				);
				$where = $db->quoteInto('user_id = ?', $userInfo->id);
				$db->update('war_members', $set, $where);
				$tpoints = $resultD["points"] + 30;
				$set = array( 
					'points'   => $tpoints
				);
				$where = $db->quoteInto('id = ?', $resultB["team_id"]);
				$db->update('war_teams', $set, $where);

				// INFORM CAMPAIGN ADMIN OF THIS
				$mail_to   = $resultE["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Node " . $node . " Hacked";
				$mail_note = "Node was defeated by plaintext sql root password";
	 			$set = array( 
					'send_id' => $mail_from,
					'recv_id' => $mail_to,
					'ip'      => $_SERVER['REMOTE_ADDR'],
					'created' => date("Y-m-d G:i:s"),
					'note'    => $mail_note,
					'en'      => "1",
					'subject' => $mail_subj
				);
				$db->insert('war_inbox', $set);

				// MAKE SURE WE GLOBAL POINT
				$upoints = $resultF["points"] + 30;
				$set = array( 
					'points'   => $upoints
				);
				$where = $db->quoteInto('id = ?', $userInfo->id);
				$db->update('authorize', $set, $where);

				// SUCCESS
				return "YAY";
			}
			else { return "UGH"; } // FAIL
		}

		// BOX PLAIN ROOT PASSWORD
		if ($opt == "40") {
			if ($ans == $resultA["sql_root_hash"]) {
				// MARK BOX AS BREACHED, HACKED WHEN CONFIRMED
				$set = array( 
					'status'   => "breach",
					'created'  => date("Y-m-d G:i:s"),
					'attack'   => $resultB["team_id"]
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);

				// WAR LOG
				$journal = "%ATTACKERS% has breached %DEFENDERS% on %CAMPAIGN% for node %BOX% by providing the plaintext system root password";
				$set = array (
					'attackers' => $resultB["team_id"],
					'defenders' => $resultA["team"],
					'defeated'  => date("Y-m-d G:i:s"),
					'journal'   => $journal,
					'campaign'  => $resultA["campaign"],
					'box'       => $node,
					'type'      => "battle",
					'admin'     => "0"
				);
				$db->insert('war_log', $set);

				// ADD POINTS TO TEAM AND PLAYER
				$mpoints = $resultB["points"] + 40;
				$set = array( 
					'points'   => $mpoints
				);
				$where = $db->quoteInto('user_id = ?', $userInfo->id);
				$db->update('war_members', $set, $where);
				$tpoints = $resultD["points"] + 40;
				$set = array( 
					'points'   => $tpoints
				);
				$where = $db->quoteInto('id = ?', $resultB["team_id"]);
				$db->update('war_teams', $set, $where);

				// INFORM CAMPAIGN ADMIN OF THIS
				$mail_to   = $resultE["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Node " . $node . " Hacked";
				$mail_note = "Node was defeated by plaintext system root password";
	 			$set = array( 
					'send_id' => $mail_from,
					'recv_id' => $mail_to,
					'ip'      => $_SERVER['REMOTE_ADDR'],
					'created' => date("Y-m-d G:i:s"),
					'note'    => $mail_note,
					'en'      => "1",
					'subject' => $mail_subj
				);
				$db->insert('war_inbox', $set);

				// MAKE SURE WE GLOBAL POINT
				$upoints = $resultF["points"] + 40;
				$set = array( 
					'points'   => $upoints
				);
				$where = $db->quoteInto('id = ?', $userInfo->id);
				$db->update('authorize', $set, $where);

				// SUCCESS
				return "YAY";
			}
			else { return "UGH"; } // FAIL
		}

		// FULL COMPROMISE
		if ($opt == "50") {
			if (!$ans) { return "UGH"; }

			// INFORM CAMPAIGN ADMIN OF THIS
			$mail_to   = $resultE["admin"];
			$mail_from = $userInfo->id;
			$mail_subj = "Node " . $node . " Hacked";
			$mail_note = "Node was fully compromised by this team id " . $resultB["team_id"] . " and the password is now " . $ans;
 			$set = array( 
				'send_id' => $mail_from,
				'recv_id' => $mail_to,
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'created' => date("Y-m-d G:i:s"),
				'note'    => $mail_note,
				'en'      => "1",
				'subject' => $mail_subj
			);
			$db->insert('war_inbox', $set);

			// AUTO RESPOND THIS HACK
			$mail_to   = $userInfo->id;
			$mail_from = $resultE["admin"];
			$mail_subj = "RE: Node " . $node . " Hacked";
			$mail_note = "Thank you for submitting this hack. Please make sure the node is shut off so I can verify. Once approved I will award you the points and add this node to your pool.";
 			$set = array( 
				'send_id' => $mail_from,
				'recv_id' => $mail_to,
				'ip'      => $_SERVER['REMOTE_ADDR'],
				'created' => date("Y-m-d G:i:s"),
				'note'    => $mail_note,
				'en'      => "1",
				'subject' => $mail_subj
			);
			$db->insert('war_inbox', $set);

			// SUCCESS
			return "YAY";
		}

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

		if ($resultZ["xcount"] < 1) { return "UGH"; } else { return "YAY"; }
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
			->where('status != ?', "hacked")
			->where('status != ?', "dead")
			->where('status != ?', "breach");
		$resultZ = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultZ) { return "UGH"; } else { return "YAY"; }
	}

}

