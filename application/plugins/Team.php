<?php

class Zend_Controller_Action_Helper_Team extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function showteam($str,$inf)
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

		$queryA = $db->select()
			->from('war_teams')
			->where('id = ?', $inf);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		if ($str == "all") {
			return $resultA;
		}
	}

	function showplayer($str) {
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

		$queryA = $db->select()
			->from('war_members')
			->where('user_id = ?', $userInfo->id);
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();

		if ($str == "team")   { return $resultA["team_id"]; }
		if ($str == "all")    { return $resultA; }
		if ($str == "status") { return $resultA["status"]; }
	}

	function progress($node,$opt,$str,$team) {
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

		// LOOKUP BOX
		$queryA = $db->select()
			->from('war_boxes')
			->where('id = ?', $node)
			->where('en = ?', "1");
		$resultA = $db->fetchRow($queryA);
		$queryA->reset();
		// LOOKUP CAMPAIGN
		$queryB = $db->select()
			->from('war_campaign')
			->where('id = ?', $resultA["campaign"]);
		$resultB = $db->fetchRow($queryB);
		$queryB->reset();

		// ARE WE ON NODE TEAM
		if ($resultA["team"] != $team) { return "UGH"; }

		if ($opt == "1") {
			// CHECK STATUS
			if ($resultA["box_sys"] == "NULL" || !$resultA["box_sys"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: Distro";
				$mail_note = "Node " . $node ." will run on ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'box_sys'   => "Pending",
					'box_ssh'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "2") {
			// CHECK STATUS
			if ($resultA["box_ftp"] == "NULL" || !$resultA["box_ftp"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: FTP";
				$mail_note = "Node " . $node ." ftp will run on ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'box_ftp'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "3") {
			// CHECK STATUS
			if ($resultA["box_http"] == "NULL" || !$resultA["box_http"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: HTTP";
				$mail_note = "Node " . $node ." http will run on ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'box_http'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "4") {
			// CHECK STATUS
			if ($resultA["box_sql"] == "NULL" || !$resultA["box_sql"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: SQL";
				$mail_note = "Node " . $node ." sql will run on ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'box_sql'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "5") {
			// CHECK STATUS
			if ($resultA["box_root_plain"] == "NULL" || !$resultA["box_root_plain"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: Root";
				$mail_note = "Node " . $node ." box root plain is ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'box_root_plain'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "6") {
			// CHECK STATUS
			if ($resultA["box_root_hash"] == "NULL" || !$resultA["box_root_hash"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: Root";
				$mail_note = "Node " . $node ." box root hash is ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'box_root_hash'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "7") {
			// CHECK STATUS
			if ($resultA["sql_root_plain"] == "NULL" || !$resultA["sql_root_plain"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: Root";
				$mail_note = "Node " . $node ." sql root plain is ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'sql_root_plain'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		if ($opt == "8") {
			// CHECK STATUS
			if ($resultA["sql_root_hash"] == "NULL" || !$resultA["sql_root_hash"]) {
				// MAIL CAMPAIGN ADMIN VERSION
				$mail_to   = $resultB["admin"];
				$mail_from = $userInfo->id;
				$mail_subj = "Progress Report: Root";
				$mail_note = "Node " . $node ." sql root hash is ". $str ."";
	 			$set = array( 
					'send_id'  => $mail_from,
					'recv_id'  => $mail_to,
					'ip'       => $_SERVER['REMOTE_ADDR'],
					'created'  => date("Y-m-d G:i:s"),
					'note'     => $mail_note,
					'en'       => "1",
					'subject'  => $mail_subj,
					'reply_id' => "0"
				);
				$db->insert('war_inbox', $set);
				// UPDATE SQL TO VERSIONS TO PENDING
				$set = array( 
					'sql_root_hash'   => "Pending"
				);
				$where = $db->quoteInto('id = ?', $node);
				$db->update('war_boxes', $set, $where);
			}
		}

		return "YAY";
	}

}

