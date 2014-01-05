<?php

class Zend_View_Helper_AccToolbar
{
	public function accToolbar ($str)
	{
		$wmf_xs = new Zend_Session_Namespace('SPLOIT');
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		$html  = "";

		if ($str == "account") {			

			if (!Zend_Auth::getInstance()->hasIdentity()) {
				$html .= "	<div align=\"right\" class=\"jhjk_toolbar_passport_css\">\n";
				$html .= "	<ul id=\"nav\">\n";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/shield/login\" class=\"tbar_menu_link\">&nbsp;Sign in&nbsp;</a></li>";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/shield/register\" class=\"tbar_menu_link\">&nbsp;Register&nbsp;</a></li>";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "	</ul>\n";
				$html .= "	</div>\n";
			}
			else {
				$queryF = $db->select()
					->from('war_inbox', array("xcount"=>"COUNT(*)"))
					->where('recv_id = ?', $userInfo->id)
					->where('en = ?', "1");
				$resultF = $db->fetchRow($queryF);
				$queryF->reset();

				$html .= "	<div class=\"jhjk_toolbar_passport_css\">\n";
				$html .= "	<ul id=\"nav\">\n";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/mail/inbox\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/note.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Messages (". $resultF["xcount"] .")&nbsp;&nbsp;</a>\n";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/account/profile\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/vcard.png\" class=\"tbar_icon\" border=\"0\">&nbsp;My Account&nbsp;</a></li>";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/shield/logout\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/exclamation.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Sign out&nbsp;</a></li>";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "	</ul>\n";
				$html .= "	</div>\n";
			}

		}

		if ($str == "panels") {
			if (!Zend_Auth::getInstance()->hasIdentity()) {
				// NULL
			}
			else {
				// User must Enroll
				if ($userInfo->rights == 1) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/enroll/app\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/layout.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Enrollment Form for Helpers&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}

				// Show Student Panel
				if ($userInfo->rights >= 1) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/war/index\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/tux.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Wargames&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
					$html .= "		<li class=\"tbar_menu\"><a href=\"/student/index\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/award_star_gold_1.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Academy&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}

				// Show Staff Panel
				if ($userInfo->rights >= 2) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/staff/index\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/layout.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Collective&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}

				// Show Admin Panel
				if ($userInfo->rights >= 3) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/admin/index\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/eye.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Zempirians&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}

			}
		}

		if ($str == "admin") {
			if (!Zend_Auth::getInstance()->hasIdentity()) {
				// NULL
			}
			else {
				if ($userInfo->rights >= 3) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/account/profile\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/layout.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Switch Back&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}
			}
		}

		if ($str == "staff") {
			if (!Zend_Auth::getInstance()->hasIdentity()) {
				// NULL
			}
			else {
				if ($userInfo->rights >= 2) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/account/profile\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/layout.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Switch Back&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}
			}
		}

		if ($str == "student") {
			if (!Zend_Auth::getInstance()->hasIdentity()) {
				// NULL
			}
			else {
				if ($userInfo->rights > 0) {
					$html .= "		<li class=\"tbar_menu\"><a href=\"/account/profile\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/layout.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Switch Back&nbsp;</a></li>";
					$html .= "	        <div class=\"tbar_sep\"></div>\n";
				}
			}
		}

		// OUTPUT HTML SOURCE
		return $html;
	}

}

