<?php

class Zend_View_Helper_RightsLookup
{
	public function rightsLookup ($str)
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		switch ($userInfo->rights) {
			case 6:
				$myvalue = "founder";
				break;
			case 5:
				$myvalue = "executive";
				break;
			case 4:
				$myvalue = "admin";
				break;
			case 3:
				$myvalue = "staff";
				break;
			case 2:
				$myvalue = "student";
				break;
			case 1:
				$myvalue = "user";
				break;
			default:
				$myvalue = "guest";
				break;
		}

		return $myvalue;
	}

}
