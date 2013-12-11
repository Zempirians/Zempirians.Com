<?php

class Zend_Controller_Action_Helper_Myprofile extends Zend_Controller_Action_Helper_Abstract
{
	function direct() {}

	function numtoval($str)
	{
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		switch ($userInfo->rights) {
			case 6:
				$myvalue = "developer";
				break;
			case 5:
				$myvalue = "staff";
				break;
			case 4:
				$myvalue = "admin";
				break;
			case 3:
				$myvalue = "officer";
				break;
			case 2:
				$myvalue = "member";
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

