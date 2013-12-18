<?php

class Zend_Controller_Action_Helper_Myarchive extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function addfile($name,$desc,$file,$ext)
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
				'gid'        => $userInfo->id,
				'ip'         => $_SERVER['REMOTE_ADDR'],
				'title'      => $name,
				'desc'       => $desc,
				'type'       => $ext,
				'name'       => "none",
				'created'    => date("Y-m-d G:i:s"),
				'en'         => "1",
				'admin_id'   => "0",
				'admin_vote' => "0",
				'admin_date' => "0000-00-00 00:00:00"
			);
			$db->insert('archives', $set);
			$newid = $db->lastInsertId();
			//$newid = $db->lastInsertValue;

			move_uploaded_file($file, "/home/zonis/domains/zempirians.com/public_html/archives/" . $userInfo->id . "_" . $newid . "." . $ext);

			$x = "YAY";
		}

		return $x;
	}

	function listall($str)
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
			case 0:
				$queryF = $db->select()
					->from('archives')
					->where('en = ?', "1");
				break;
			case 1:
				$queryF = $db->select()
					->from('archives')
					->where('type = ?', "txt")
					->orwhere('type = ?', "pdf")
					->where('en = ?', "1");
				break;
			default:
				$myvalue = "ugh";
				break;
		}

		if ($myvalue == "ugh") {
			$resultF = "ugh";
		}
		else {
			$resultF = $db->fetchAll($queryF);
			$queryF->reset();
		}

		return $resultF;
	}
}

