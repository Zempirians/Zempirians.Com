<?php

class Zend_Controller_Action_Helper_Staff extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function schoollist($str)
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
				$myvalue = "school_curriculum";
				break;
			case 2:
				$myvalue = "school_course";
				break;
			case 3:
				$myvalue = "school_lesson";
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
				->from($myvalue)
				->where('en = ?', "1")
				->where('admin_vote = ?', "1")
				->orWhere('owner_id = ?', $userInfo->id)
				->where('en = ?', "1");
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}

	function savecurriculum($name,$level,$desc,$id)
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

		$queryF = $db->select()
			->from('school_curriculum')
			->where('id = ?', $id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

			if ($userInfo->rights >= 3 || $userInfo->id == $resultF["owner_id"]) {
				// BACKUP
	 			$set = array( 
					'nid'          => $resultF["id"],
					'name'         => $resultF["name"],
					'description'  => $resultF["description"],
					'level'        => $resultF["level"],
					'owner_id'     => $resultF["owner_id"],
					'owner_create' => $resultF["owner_create"],
					'owner_ip'     => $resultF["owner_ip"],
					'admin_id'     => $resultF["admin_id"],
					'admin_create' => $resultF["admin_create"],
					'admin_vote'   => $resultF["admin_vote"],
					'en'           => $resultF["en"]
				);
				$db->insert('backup_curriculum', $set);
				// UPDATE
				$set = array( 
					'name'         => $name,
					'description'  => $desc,
					'level'        => $level,
					'owner_id'     => $userInfo->id,
					'owner_create' => date("Y-m-d G:i:s"),
					'owner_ip'     => $_SERVER['REMOTE_ADDR'],
					'admin_id'     => "0",
					'admin_create' => "0000-00-00 00:00:00",
					'admin_vote'   => "0",
					'en'           => "1"
				);
				$where = $db->quoteInto('id = ?', $id);
				$db->update('school_curriculum', $set, $where);

				$x = "YAY";
			}

		return $x;
	}

	function savecourse($name,$level,$desc,$parent,$id)
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

		$queryF = $db->select()
			->from('school_course')
			->where('id = ?', $id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

			if ($userInfo->rights >= 3 || $userInfo->id == $resultF["owner_id"]) {
				// BACKUP
	 			$set = array( 
					'nid'          => $resultF["id"],
					'name'         => $resultF["name"],
					'description'  => $resultF["description"],
					'level'        => $resultF["level"],
					'pid'          => $resultF["pid"],
					'owner_id'     => $resultF["owner_id"],
					'owner_create' => $resultF["owner_create"],
					'owner_ip'     => $resultF["owner_ip"],
					'admin_id'     => $resultF["admin_id"],
					'admin_create' => $resultF["admin_create"],
					'admin_vote'   => $resultF["admin_vote"],
					'en'           => $resultF["en"]
				);
				$db->insert('backup_course', $set);
				// UPDATE
				$set = array( 
					'name'         => $name,
					'description'  => $desc,
					'level'        => $level,
					'pid'          => $parent,
					'owner_id'     => $userInfo->id,
					'owner_create' => date("Y-m-d G:i:s"),
					'owner_ip'     => $_SERVER['REMOTE_ADDR'],
					'admin_id'     => "0",
					'admin_create' => "0000-00-00 00:00:00",
					'admin_vote'   => "0",
					'en'           => "1"
				);
				$where = $db->quoteInto('id = ?', $id);
				$db->update('school_course', $set, $where);

				$x = "YAY";
			}

		return $x;
	}

	function savelesson($name,$level,$desc,$parent,$child,$id)
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

		$queryF = $db->select()
			->from('school_lesson')
			->where('id = ?', $id);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

			if ($userInfo->rights >= 3 || $userInfo->id == $resultF["owner_id"]) {
				// BACKUP
	 			$set = array( 
					'nid'          => $resultF["id"],
					'name'         => $resultF["name"],
					'description'  => $resultF["description"],
					'level'        => $resultF["level"],
					'pid'          => $resultF["pid"],
					'cid'          => $resultF["cid"],
					'owner_id'     => $resultF["owner_id"],
					'owner_create' => $resultF["owner_create"],
					'owner_ip'     => $resultF["owner_ip"],
					'admin_id'     => $resultF["admin_id"],
					'admin_create' => $resultF["admin_create"],
					'admin_vote'   => $resultF["admin_vote"],
					'en'           => $resultF["en"]
				);
				$db->insert('backup_lesson', $set);
				// UPDATE
				$set = array( 
					'name'         => $name,
					'description'  => $desc,
					'level'        => $level,
					'pid'          => $parent,
					'cid'          => $child,
					'owner_id'     => $userInfo->id,
					'owner_create' => date("Y-m-d G:i:s"),
					'owner_ip'     => $_SERVER['REMOTE_ADDR'],
					'admin_id'     => "0",
					'admin_create' => "0000-00-00 00:00:00",
					'admin_vote'   => "0",
					'en'           => "1"
				);
				$where = $db->quoteInto('id = ?', $id);
				$db->update('school_lesson', $set, $where);

				$x = "YAY";
			}

		return $x;
	}


	function gocurriculum($name,$level,$desc)
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

		if ($userInfo->rights > 1) {
 			$set = array( 
				'name'         => $name,
				'description'  => $desc,
				'level'        => $level,
				'owner_id'     => $userInfo->id,
				'owner_create' => date("Y-m-d G:i:s"),
				'owner_ip'     => $_SERVER['REMOTE_ADDR'],
				'admin_id'     => "0",
				'admin_create' => "0000-00-00 00:00:00",
				'admin_vote'   => "0",
				'en'           => "1"
			);
			$db->insert('school_curriculum', $set);
			$x = "YAY";
		}

		return $x;
	}

	function gocourse($name,$level,$desc,$parent)
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

		if ($userInfo->rights > 1) {
 			$set = array( 
				'name'         => $name,
				'description'  => $desc,
				'level'        => $level,
				'pid'          => $parent,
				'owner_id'     => $userInfo->id,
				'owner_create' => date("Y-m-d G:i:s"),
				'owner_ip'     => $_SERVER['REMOTE_ADDR'],
				'admin_id'     => "0",
				'admin_create' => "0000-00-00 00:00:00",
				'admin_vote'   => "0",
				'en'           => "1"
			);
			$db->insert('school_course', $set);
			$x = "YAY";
		}

		return $x;
	}

	function golesson($name,$level,$desc,$parent,$child)
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

		if ($userInfo->rights > 1) {
 			$set = array( 
				'name'         => $name,
				'description'  => $desc,
				'level'        => $level,
				'pid'          => $parent,
				'cid'          => $child,
				'owner_id'     => $userInfo->id,
				'owner_create' => date("Y-m-d G:i:s"),
				'owner_ip'     => $_SERVER['REMOTE_ADDR'],
				'admin_id'     => "0",
				'admin_create' => "0000-00-00 00:00:00",
				'admin_vote'   => "0",
				'en'           => "1"
			);
			$db->insert('school_lesson', $set);
			$x = "YAY";
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

		$queryF = $db->select()
			->from('school_course')
			->where('id = ?', $a);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

			if ($userInfo->rights >= 3 || $userInfo->id == $resultF["owner_id"]) {

				switch ($name) {
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
			}
			else { $x = "UGH"; }

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

		$queryF = $db->select()
			->from('school_lesson')
			->where('id = ?', $a);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

			if ($userInfo->rights >= 3 || $userInfo->id == $resultF["owner_id"]) {

				switch ($name) {
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
			}
			else { $x = "UGH"; }

		return $x;
	}

}

