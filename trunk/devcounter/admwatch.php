<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Administrate Frequently Asked Questions
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: admwatch.php,v 1.1 2002/09/16 18:45:50 helix Exp $
#
######################################################################  

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("./include/header.inc");

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,$th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);

$db2 = new DB_DevCounter;
$db3 = new DB_DevCounter;
?>

<!-- content -->
<?php
if (($config_perm_admwatch != "all") && (!isset($perm) || !$perm->have_perm($config_perm_admwatch))) {
	$be->box_full($t->translate("Error"), $t->translate("Access denied"));
} else {
	$db->query("SELECT colname FROM prog_abilities WHERE translation='English'");
	while ($db->next_record()) {
		$abilnam[] = $db->f("colname");
	}
	$db->query("SELECT colname FROM prog_languages");
	while ($db->next_record()) {
		$langnam[] = $db->f("colname");
	}

	$db->query("SELECT auth_user.username,email_usr FROM prog_ability_watch,auth_user WHERE prog_ability_watch.username=auth_user.username");
	while ($db->next_record()) {
		$usrnam = $db->f("username");
		$email = $db->f("email_usr");
		$count = 0;

		reset ($abilnam);
		while (list(, $abil) = each ($abilnam)) {
			$db2->query("SELECT $abil FROM prog_ability_watch WHERE username='$usrnam'");
//			echo "<p>SELECT $abil FROM prog_ability_watch WHERE username='$usrnam'\n";
			if ($db2->next_record()) {
				$abilities[$abil] = $db2->f($abil);
			}
		}

		reset ($abilities);
		$where = "";
		while (list($name, $value) = each ($abilities)) {
			if ($where != "") $where .= " AND ";
			$where .= "$name>='$value'";
		}
		$db2->query("SELECT * FROM prog_ability_values WHERE $where");
//		echo "<p>SELECT * FROM prog_ability_values WHERE $where\n";
		while ($db2->next_record()) {
			$fusrnam = $db2->f("username");
//			echo "<p>Match abilities: $fusrnam\n";

			reset ($langnam);
			while (list(, $lang) = each ($langnam)) {
				$db3->query("SELECT $lang FROM prog_language_watch WHERE username='$usrnam'");
//				echo "<p>SELECT $lang FROM prog_language_watch WHERE username='$usrnam'\n";
				if ($db3->next_record()) {
					$languages[$lang] = $db3->f($lang);
				}
			}

			reset ($languages);
			$where2 = "";
			while (list($name2, $value2) = each ($languages)) {
				if ($where2 != "") $where2 .= " AND ";
				$where2 .= "$name2>='$value2'";
			}
			$db3->query("SELECT * FROM prog_language_values WHERE $where2 AND username='$fusrnam'");
//			echo "<p>SELECT * FROM prog_language_values WHERE $where2 AND username='$fusrnam'\n";
			while ($db3->next_record()) {
				$count++;
				if ($count == 1) echo "<p>The following Developers match with your ($usrnam &lt;$email&gt;) Watch:<br>\n";
				$fusrnam2 = $db3->f("username");
				echo "<br>$fusrnam2 (<a href=\"".$sys_url."showprofile.php?devname=$fusrnam2\">".$sys_url."showprofile.php?devname=$fusrnam2</a>)\n";
			}
		}	
	}
}
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
