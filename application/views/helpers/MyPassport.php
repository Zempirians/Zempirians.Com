<?php

class Zend_View_Helper_MyPassport
{
	public function myPassport ($str)
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
				$html .= "	<div class=\"jhjk_toolbar_passport_css\">\n";
				$html .= "	<ul id=\"nav\">\n";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/account/profile\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/vcard.png\" class=\"tbar_icon\" border=\"0\">&nbsp;My Account&nbsp;</a></li>";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "		<li class=\"tbar_menu\"><a href=\"/shield/logout\" class=\"tbar_menu_link\">&nbsp;<img src=\"/sthemes/0/ico/exclamation.png\" class=\"tbar_icon\" border=\"0\">&nbsp;Sign out&nbsp;</a></li>";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
				$html .= "	</ul>\n";
				$html .= "	</div>\n";
			}

			// OUTPUT HTML SOURCE
			return $html;
	}

}

