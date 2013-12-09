<?php

class Zend_View_Helper_JhjkBackground
{
	public function jhjkBackground ($theme)
	{
		$wmf_ns = new Zend_Session_Namespace('SPLOIT');

		if (!$theme) {
			$mytheme = 0;
			$wmf_ns->theme = 0;
			$wmf_ns->dirtheme = "/sthemes/0";
		} else {
			if (is_numeric($theme)) {
				$mytheme = $theme;
				$wmf_ns->theme = $mytheme;
				$wmf_ns->dirtheme = "/sthemes/" . $mytheme;
			} else {
				$mytheme = 0;
				$wmf_ns->theme = 0;
				$wmf_ns->dirtheme = "/sthemes/0";
			}
		}

		return $mytheme;
	}

}
