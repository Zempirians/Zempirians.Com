<?php

class Zend_View_Helper_WarProgress
{
	public function warProgress ($str)
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

		$queryF = $db->select()
			->from('war_boxes')
			->where('id = ?', $str);
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();

		$done = 0;

		if ($resultF["box_root_plain"] != "" && $resultF["box_root_plain"] != "Pending" && $resultF["box_root_plain"] != "NULL") { $done = $done + 1; }
		if ($resultF["box_root_hash"]  != "" && $resultF["box_root_hash"]  != "Pending" && $resultF["box_root_hash"]  != "NULL") { $done = $done + 1; }
		if ($resultF["sql_root_plain"] != "" && $resultF["sql_root_plain"] != "Pending" && $resultF["sql_root_plain"] != "NULL") { $done = $done + 1; }
		if ($resultF["sql_root_hash"]  != "" && $resultF["sql_root_hash"]  != "Pending" && $resultF["sql_root_hash"]  != "NULL") { $done = $done + 1; }
		if ($resultF["box_sys"]        != "" && $resultF["box_sys"]        != "Pending" && $resultF["box_sys"]        != "NULL") { $done = $done + 1; }
		if ($resultF["box_ssh"]        != "" && $resultF["box_ssh"]        != "Pending" && $resultF["box_ssh"]        != "NULL") { $done = $done + 1; }
		if ($resultF["box_ssh_lport"]  != "" && $resultF["box_ssh_lport"]  != "Pending" && $resultF["box_ssh_lport"]  != "NULL") { $done = $done + 1; }
		if ($resultF["box_ssh_rport"]  != "" && $resultF["box_ssh_rport"]  != "Pending" && $resultF["box_ssh_rport"]  != "NULL") { $done = $done + 1; }
		if ($resultF["box_ftp"]        != "" && $resultF["box_ftp"]        != "Pending" && $resultF["box_ftp"]        != "NULL") { $done = $done + 1; }
		if ($resultF["box_ftp_rport"]  != "" && $resultF["box_ftp_rport"]  != "Pending" && $resultF["box_ftp_rport"]  != "NULL") { $done = $done + 1; }
		if ($resultF["box_ftp_lport"]  != "" && $resultF["box_ftp_lport"]  != "Pending" && $resultF["box_ftp_lport"]  != "NULL") { $done = $done + 1; }
		if ($resultF["box_http"]       != "" && $resultF["box_http"]       != "Pending" && $resultF["box_http"]       != "NULL") { $done = $done + 1; }
		if ($resultF["box_http_rport"] != "" && $resultF["box_http_rport"] != "Pending" && $resultF["box_http_rport"] != "NULL") { $done = $done + 1; }
		if ($resultF["box_http_lport"] != "" && $resultF["box_http_lport"] != "Pending" && $resultF["box_http_lport"] != "NULL") { $done = $done + 1; }
		if ($resultF["box_sql"]        != "" && $resultF["box_sql"]        != "Pending" && $resultF["box_sql"]        != "NULL") { $done = $done + 1; }
		if ($resultF["box_sql_rport"]  != "" && $resultF["box_sql_rport"]  != "Pending" && $resultF["box_sql_rport"]  != "NULL") { $done = $done + 1; }
		if ($resultF["box_sql_lport"]  != "" && $resultF["box_sql_lport"]  != "Pending" && $resultF["box_sql_lport"]  != "NULL") { $done = $done + 1; }

		return $done;

	}

}
