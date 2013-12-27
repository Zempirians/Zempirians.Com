<?php

class Zend_Controller_Action_Helper_Mailcheck extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function delete($str)
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
			->from('war_inbox')
			->where('id = ?', $str)
			->where('recv_id = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {
			return "UGH";
		} else {
			$set = array( 
				'en'   => "0"
			);
			$where = $db->quoteInto('id = ?', $str);
			$db->update('war_inbox', $set, $where);
			return "YAY";
		}
	}

	function reply($id,$note)
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
			->from('war_inbox')
			->where('id = ?', $id)
			->where('recv_id = ?', $userInfo->id);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {
			return "UGH";
		} else {

			$mail_to   = $resultF["send_id"];
			$mail_from = $userInfo->id;
			$mail_subj = "RE: " . $resultF["subject"];
			$mail_note = $note;

 			$set = array( 
				'send_id'  => $mail_from,
				'recv_id'  => $mail_to,
				'ip'       => $_SERVER['REMOTE_ADDR'],
				'created'  => date("Y-m-d G:i:s"),
				'note'     => $mail_note,
				'en'       => "1",
				'subject'  => $mail_subj,
				'reply_id' => $id
			);
			$db->insert('war_inbox', $set);

			return "YAY";
		}
	}

	function compose($id,$note)
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
			->from('authorize')
			->where('id = ?', $id);
		$resultF = $db->fetchRow($queryE);
		$queryE->reset();

		if (!$resultF) {
			return "UGH";
		} else {

			$mail_to   = $id;
			$mail_from = $userInfo->id;
			$mail_subj = "Private Message";
			$mail_note = $note;

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

			return "YAY";
		}
	}

}

