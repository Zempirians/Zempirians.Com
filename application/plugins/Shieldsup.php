<?php

class Zend_Controller_Action_Helper_Shieldsup extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function timeban($area,$meth,$type)
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

		//if ($userInfo->id <= 0) {
			$c_id = 0;
		//} else {
		//	$c_id = $userInfo->id;
		//}
		// CHECK FOR LOG
		$queryF = $db->select()
			->from('log_usage')
			->where('owner = ?', $c_id)
			->where('area = ?', $area)
			->where('method = ?', $meth)
			->where('descrip = ?', $type)
			->order('completed DESC');
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		//$xdate = date("Y-m-d G:i:s");

		if (!$resultF["completed"]) { return "YAY"; }

		$logtime = strtotime(date("Y-m-d G:i:s"));
		$tmptime = strtotime($resultF["completed"]);

		$answer  = $logtime-$tmptime;

		if ($answer < 300) {
			return "UGH";
		} else {
			return "YAY";
		}
	}

	function surflog($area,$meth,$type,$pts)
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

		//$mystr = $_SERVER['REQUEST_URI'] . "(" . $_SERVER['QUERY_STRING'] . ")";
		$mystr = $_SERVER['REQUEST_URI'];
		$mysan = htmlspecialchars($mystr);

		//if (!$userInfo->id) {
			$c_id = 0;
		//} else {
		//	$c_id = $userInfo->id;
		//}

	// LOG THE PROCESS
		$set = array (
			'owner'     => $c_id,
			'area'      => $area,
			'method'    => $meth,
			'descrip'   => $type,
			'points'    => $pts,
			'completed' => date("Y-m-d G:i:s"),
			'ip'        => $_SERVER['REMOTE_ADDR'],
			'notes'     => $mysan
		);
		$db->insert('log_usage', $set);
	}


	function paramcli($str)
	{
		$lockdown = "UGH";

		if (!ereg('[^a-zA-Z0-9\_\.\-]{1,}$', $str)) {
			$lockdown = "YAY";
		}

		return $lockdown;
	}

	function paramnum($str)
	{
		$lockdown = "UGH";
		$envbox   = htmlspecialchars($str);
		if (is_numeric($envbox)) {
			$lockdown = "YAY";
		}
		return $lockdown;
	}

	function paramtxt($str)
	{
		$lockdown = "UGH";
		$envbox   = htmlspecialchars($str);
		if (!$envbox) {
			$lockdown = "UGH";
		} else {
			$lockdown = "YAY";
		}
		return $lockdown;
	}

	function parameml($str)
	{
		$lockdown = "UGH";
		$envbox   = htmlspecialchars($str);
		
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $str)) {
			$lockdown = "UGH";
		} else {
			$lockdown = "YAY";
		}
		return $lockdown;
	}

}

