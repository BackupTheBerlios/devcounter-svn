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
# Form to set Developers watch for users.
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: watch.php,v 1.2 2002/08/26 10:15:04 helix Exp $
#
######################################################################

page_open(array("sess" => "DevCounter_Session",
                "auth" => "DevCounter_Auth",
                "perm" => "DevCounter_Perm"));

require("header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

$db2 = new DB_DevCounter;
$db3 = new DB_DevCounter;

?>

<!-- content -->
<?php
if (($config_perm_watch != "all") && (!isset($perm) || !$perm->have_perm($config_perm_watch))) {
    $be->box_full($t->translate("Error"), $t->translate("Access denied"));
} else {
   $username = $auth->auth["uname"];
   htmlp_form_action("watchset.php",array(),"POST");
   echo "\n";

   $db3->query("SELECT * FROM prog_ability_watch WHERE username='$username'");
   if ($db3->next_record())
     $exists = 1;
   else
     $exists = 0;

   $bx->box_begin();
   $bx->box_title($t->translate("Set Watch"));
   $bx->box_body_begin();

   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";
   echo "<tr><td align=center><B>".$t->translate("Which programming expiriences you like to watch?")."</B></td></tr><tr><td>\n";
   echo "<center><table border=0>\n";

   $db->query("SELECT * from prog_abilities WHERE translation='$la'");

   while ($db->next_record()) {
      $ability_code = $db->f("code");
      $colname = $db->f("colname");
      echo "<tr><td align=right>".$db->f("ability")."</td><td>\n";
      htmlp_select("ability[".$ability_code."]"); 
      $db2->query("SELECT * FROM weightings");
      while ($db2->next_record()) {
		 $weightid = $db2->f("weightid");
		 $weighting = $db2->f("weighting");
         $select = 0;
         if ($exists) {
            $exist_weighting = $db3->f($colname);
            if ($exist_weighting == $weightid)
               $select = 1;
         }
         htmlp_select_option("$weightid",$select,$t->translate($weighting));
      }
      htmlp_select_end();
      echo "</td></tr>\n";
   }

   echo "</table></center>\n";
   echo "</table>";

   $bx->box_body_end();

   $db3->query("SELECT * FROM prog_language_watch WHERE username='".$auth->auth["uname"]."'");
   if ($db3->next_record())
     $exists = 1;
   else
     $exists = 0;

   $bx->box_body_begin();

   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B>".$t->translate("Which languages/tools you like to watch?")."</B></td></tr><tr><td>\n";
   echo "<center><table border=0>\n";

   $db->query("SELECT * from prog_languages");

   while ($db->next_record()) {
      $language_code = $db->f("code");
      $colname = $db->f("colname");
      echo "<tr><td align=right>".$db->f("language")."</td><td>\n";
      htmlp_select("plang[".$language_code."]"); 
      $db2->query("SELECT * FROM weightings");
      while ($db2->next_record()) {
		 $weightid = $db2->f("weightid");
		 $weighting = $db2->f("weighting");
         $select = 0;
         if ($exists) {
            $exist_weighting = $db3->f($colname);
            if ($exist_weighting == $weightid)
               $select = 1;
         }
         htmlp_select_option("$weightid",$select,$t->translate($weighting));
      }
      htmlp_select_end();

      echo "</td></tr>\n";
   }

   echo "</table></center>\n";
   echo "</table>";

   $bx->box_body_end();
   $bx->box_end();

   echo "<CENTER>";
   htmlp_form_submit($t->translate("Submit"),"");
   echo "</CENTER><br>&nbsp;\n";
}
?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
