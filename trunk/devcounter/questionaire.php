<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#       Stefan Heinze (heinze@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Form to initially ask for developers profile
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: questionaire.php,v 1.6 2002/09/16 21:39:40 helix Exp $
#
######################################################################

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) 
{
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("./include/header.inc");

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
$db3 = new DB_DevCounter;
?>

<!-- content -->
<?php
if (empty($auth->auth["uname"]))
   $be->box_full($t->translate("Not logged in"), $t->translate("Please login first"));
else
  {
   $bx->box_begin();
   $bx->box_title($t->translate("Personal Data"));
   $bx->box_body_begin();
  
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";
   htmlp_form_action("insert.php","","GET");
   echo "\n";

   $username=$auth->auth["uname"];

   htmlp_form_hidden("username", $username);
   echo "<tr><td align=right width=30%>".$t->translate("Username").":</td><td width=70%> $username\n";

   echo "<tr><td align=right width=30%>".$t->translate("Nationality").":</td><td width=70%>\n";
   htmlp_select("nationality"); echo "\n";
   select_country(999);
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Country you currently live in").":</td><td width=70%>\n";
   htmlp_select("actual_country"); echo "\n";
   select_country(999);
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Year of Birth").":</td><td width=70%>19<input type=\"TEXT\" name=\"year_of_birth\" size=3 maxlength=2></td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Gender").":</td><td width=70%>\n";
   echo "<center><table width=80% border=0>\n";
   echo "<tr>";

   $db3->query("SELECT * FROM gender");
   while ($db3->next_record()) {
      $selected = 0;
      if ($db3->f("gendid") == 1) $selected = 1;
      echo "<td width=26%>";
      htmlp_radio("gender",$db3->f("gendid"),$selected);
      echo "&nbsp; ".$t->translate($db3->f("gender"))."\n";
      echo "</td>\n";
   }
   echo "</tr></table></center>\n";
   echo "</td></tr>\n";
   echo "<tr><td align=right width=30%>".$t->translate("Mother tongue").":</td><td width=70%>\n";
   htmlp_select("mother_tongue"); echo "\n";
   select_lang(999);
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right valign=top width=30%><BR>".$t->translate("Other languages").":</td><td width=70%>\n";
   echo "<table width=90% border=0>\n";
   echo "<tr>";
   echo "<td width=25% valign=top>2. ";
   htmlp_select("other_lang_1"); echo "\n";
   select_lang(999);
   htmlp_select_end(); echo "</td>\n";
   echo "<td width=25% valign=top>3. ";
   htmlp_select("other_lang_2"); echo "\n";
   select_lang(999);
   htmlp_select_end(); echo "</td>\n";

   echo "</td></tr>\n";
   echo "</table>\n";
   echo "</td></tr>\n";
   echo "</table>\n";

   $bx->box_body_end();
   $bx->box_end();

   $bx->box_begin();
   $bx->box_title($t->translate("Professional Data"));
   $bx->box_body_begin();
 
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Profession").":</td><td width=70%>\n";
   htmlp_select("profession");

   $db3->query("SELECT * FROM profession");
   while ($db3->next_record()) {
      $selected = 0;
      if ($db3->f("profid") == 1) $selected = 1;
      htmlp_select_option($db3->f("profid"),$selected,$t->translate($db3->f("profession")));
   }
   htmlp_select_end();
   echo "</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Qualification").":</td><td width=70%>\n";
   htmlp_select("qualification");

   $db3->query("SELECT * FROM qualification");
   while ($db3->next_record()) {
      $selected = 0;
      if ($db3->f("qualid") == 1) $selected = 1;
      htmlp_select_option($db3->f("qualid"),$selected,$t->translate($db3->f("qualification")));
   }

   htmlp_select_end();
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();

   $bx->box_begin();
   $bx->box_title($t->translate("Computer experience"));
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=left>".$t->translate("Number of Free Software/Open Source Projects you are involved in").": <input type=\"TEXT\" name=\"number_of_projects\" value=\"0\" size=\"3\" maxlength=\"2\">\n";
   echo "</tr>\n";

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><B><FONT SIZE=+1>".$t->translate("Which of these programming expirience do you have?")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table width=90% border=0>\n";

   $db->query("SELECT * from prog_abilities WHERE translation='$la'");
   $ability_amount=$db->num_rows();
   $counter=0;
   while ($counter<$ability_amount)
     {
      $counter++;
      $db->next_record();
      if (($counter % 2)==1)
         echo "<tr><td width=33%>\n"; 
      else
         echo "<td width=33%>\n";
      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("ability")."\n";
      echo "</td><td width=20%>";
      htmlp_select("ability[".$db->f("code")."]");
      $db2->query("SELECT * FROM weightings");
      while ($db2->next_record()) {
         $selected = 0;
         if ($db2->f("weightid") == 0) $selected = 1;
         htmlp_select_option($db2->f("weightid"),$selected,$t->translate($db2->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 2)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 2)==0)
      echo "</tr>\n\n";
   htmlp_form_hidden("ability_amount", $ability_amount);
  
   echo "</table></center>\n";

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><FONT SIZE=+1>".$t->translate("Which of these languages/tools are you experienced with?")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table border=0>\n";

   $db->query("SELECT * from prog_languages");
   $lang_amount=$db->num_rows();
   $counter=0;
   while ($counter<$lang_amount)
     {
      $counter++;
      $db->next_record();
      if (($counter % 2)==1)
         echo "<tr><td width=33%>\n"; 
      else
        echo "<td width=33%>\n";
      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("language")."\n";
      echo "</td><td width=20%>";
      htmlp_select("plang[".$db->f("code")."]");
      $db2->seek(0);
      while ($db2->next_record()) {
         $selected = 0;
         if ($db2->f("weightid") == 0) $selected = 1;
         htmlp_select_option($db2->f("weightid"),$selected,$t->translate($db2->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 2)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 2)==0)
      echo "</tr>\n\n";
   htmlp_form_hidden("lang_amount", $lang_amount);

   echo "</table></center>\n";
   echo "</td></tr>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();

   echo"<CENTER><TABLE BORDER=0 width=89%><TR><TD width=65%>\n";

   echo "<CENTER>";
   htmlp_form_submit($t->translate("Submit"),"");
   echo "</CENTER>";

   echo "</td></tr>\n";
   echo "</table>\n";

   echo"</TD><TD width=5%>&nbsp;\n";
   echo"</TD><TD width=30%>\n";
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
