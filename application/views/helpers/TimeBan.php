<?php

class Zend_View_Helper_TimeBan
{
	public function timeBan ($area,$meth,$type)
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

		$queryF = $db->select()
			->from('log_usage')
			->where('owner = ?', "0")
			->where('area = ?', $area)
			->where('method = ?', $meth)
			->where('descrip = ?', $type)
			->order('completed DESC');
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		$logtime = strtotime(date("Y-m-d G:i:s"));
		$tmptime = strtotime($resultF["completed"]);

		$diff   = $logtime - $tmptime;
		$answer = 300 - $diff;

		if ($answer < 300) {
			return $answer;
		}

		return $answer;
	}

}
