<?php

class Zend_View_Helper_SiteToolbar
{
	public function siteToolbar ($str)
	{
		$wmf_xs = new Zend_Session_Namespace('SPLOIT');
		$xray   = Zend_Registry::getInstance();
		$config = array(
			'host'     => $xray->host,
			'username' => $xray->username,
			'password' => $xray->password,
			'dbname'   => $xray->dbname
		);
		$db = Zend_Db::factory('Pdo_Mysql', $config);

		// CHECK FOR PARENTS
		$queryF = $db->select()
			->from('site_toolbar', array("xcount"=>"COUNT(*)"))
			->where('status = ?', "parent")
			->where('en = ?', "1");
		$resultF = $db->fetchRow($queryF);
		$queryF->reset();
		
		// TOOLBAR HAS MENUS, PROCESS
		if ($resultF["xcount"] > 0) {

			$html  = "";
			$html .= "<div id=\"jhjk_toolbar\">\n";
			$html .= "	<div class=\"jhjk_toolbar_css\">\n";
			$html .= "	<ul id=\"nav\">\n";
			$html .= "	        <div class=\"tbar_sep\"></div>\n";

			// SUMMON ALL PARENTS
			$queryK = $db->select()
				->from('site_toolbar')
				->where('status = ?', "parent")
				->where('en = ?', "1")
				->order('name ASC');
			$resultK = $db->fetchAll($queryK);
			$queryK->reset();

			// LOOP THROUGH PARENTS AND BUILD LINKS
			foreach ($resultK as $parent) {

				// CHECK FOR CHILDREN
				$queryL = $db->select()
					->from('site_toolbar', array("xcount"=>"COUNT(*)"))
					->where('status = ?', "child")
					->where('gid = ?', $parent["id"])
					->where('en = ?', "1");
				$resultL = $db->fetchRow($queryL);
				$queryL->reset();

				$html .= "		<li class=\"tbar_menu\"><a href=\"". $parent["link"] ."\" class=\"tbar_menu_link\">&nbsp;<img src=\"". $wmf_xs->dirtheme . $parent["icon"] . "\" class=\"tbar_icon\" border=\"0\">&nbsp;". $parent["name"] ."";
					if ($resultL["xcount"] > 0) {
						$html .= "&nbsp;&nbsp;<img src=\"". $wmf_xs->dirtheme ."/ico/bullet_arrow_down.png\" class=\"tbar_icon_r\" border=\"0\">&nbsp;</a>\n";
						$html .= "			<ul>\n";

						// SUMMON ALL CHILDREN
						$queryM = $db->select()
							->from('site_toolbar')
							->where('status = ?', "child")
							->where('gid = ?', $parent["id"])
							->where('en = ?', "1")
							->order('name ASC');
						$resultM = $db->fetchAll($queryM);
						$queryM->reset();

						// LOOP THROUGH CHILDREN AND BUILD LINKS
						foreach ($resultM as $child) {

							// CHECK FOR BABIES
							$queryN = $db->select()
								->from('site_toolbar', array("xcount"=>"COUNT(*)"))
								->where('status = ?', "baby")
								->where('gid = ?', $child["id"])
								->where('en = ?', "1");
							$resultN = $db->fetchRow($queryN);
							$queryN->reset();

							$html .= "				<li class=\"tbar_menu\"><a href=\"". $child["link"] ."\" class=\"tbar_menu_link\">&nbsp;<img src=\"". $wmf_xs->dirtheme . $child["icon"] ."\" class=\"tbar_icon\" border=\"0\">&nbsp;". $child["name"] ."";
								if ($resultN["xcount"] > 0) {
									$html .= "&nbsp;&nbsp;<img src=\"". $wmf_xs->dirtheme ."/ico/bullet_arrow_right.png\" class=\"tbar_icon_r\" border=\"0\">&nbsp;</a>\n";
									$html .= "					<ul>\n";

										// SUMMON ALL BABIES
										$queryO = $db->select()
											->from('site_toolbar')
											->where('status = ?', "baby")
											->where('gid = ?', $child["id"])
											->where('en = ?', "1")
											->order('name ASC');
										$resultO = $db->fetchAll($queryO);
										$queryO->reset();

										foreach ($resultO as $baby) {
											$html .= "						<li class=\"tbar_menu\"><a href=\"". $baby["link"] ."\" class=\"tbar_menu_link\">&nbsp;<img src=\"". $wmf_xs->dirtheme . $baby["icon"] ."\" class=\"tbar_icon\" border=\"0\">&nbsp;". $baby["name"] ."&nbsp;</a></li>\n";
										}

									$html .= "					</ul>\n";
									$html .= "				</li>\n";
								} else {
									$html .= "&nbsp;</a></li>\n";
								}
						}

						$html .= "			</ul>\n";
						$html .= "		</li>\n";
					} else {
						$html .= "&nbsp;</a></li>\n";
					}


				$html .= "		</li>\n";
				$html .= "	        <div class=\"tbar_sep\"></div>\n";
			}

			$html .= "	</ul>\n";
			$html .= "	</div>\n";
			$html .= "</div>\n";

			// OUTPUT HTML SOURCE
			return $html;
		}
		else {
			return "ERROR: The toolbar is currently not available.";
		}
	}

}
