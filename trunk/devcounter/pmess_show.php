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
# This file contains the verification procedure when registering
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: pmess_show.php,v 1.1 2003/02/26 13:21:40 masato Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,$th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php

if (!isset($pmessid) || empty($pmessid))
  {
   /*
   if (!isset($offset) || empty($offset)|| $offset<1 ) 
     {
      $offset = 0;
     }
   if (!isset($limit) || empty($limit)|| $limit<1) 
     {
      $limit = 25;
     }
   
   $msg = "[ ";
   if ($offset>0)
     {
      $new_offset=$offset-$limit;
      if ($new_offset<0)
        { $new_offset=0; }
      $nquery["offset"] =  $new_offset;
      $nquery["limit"] =  $limit;
      $msg .= " ".html_link("pmess_show.php",$nquery,"&lt; ".$t->translate("previous page"))." | ";
     }
   else
     {
      $msg .= "&lt; ".$t->translate("previous page")." | ";
     }

   $new_offset = $offset+$limit;
   $db->query("SELECT * FROM pmessages ORDER BY pmesstime DESC LIMIT $new_offset,$limit");
   if ($db->num_rows()>0)
     {
      $nquery["offset"] =  $new_offset;
      $nquery["limit"] =  $limit;
      $msg .= " ".html_link("pmess_show.php",$nquery," ".$t->translate("next page"))." &gt; ";
      
     }   
   else
     {
      $msg .= " ".$t->translate("next page")." &gt; ";
     }
   $msg .= "]";
   
   $bs->box_strip($msg);
   $db->query("SELECT * FROM pmessages ORDER BY reqtime DESC LIMIT $offset,$limit");
   $number_of_requests=$db->num_rows();
   $counter=0;
   $bx->box_begin();
   $bx->box_body_begin();
   $bx->box_columns_begin(6);
   $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Subject")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Developer")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Time")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Task")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Type")."</b>");
   $bx->box_column("center","15%", $th_strip_title_bgcolor,"<b>".$t->translate("Language")."</b>");
   $bx->box_next_row_of_columns();
   $bgcolor = "#FFFFFF";
   while ($counter!=$number_of_requests)
     {
      $db->next_record();
      $counter++;
      if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
      else {$bgcolor = "#E0E0E0";}
      $bx->box_column("right","",$bgcolor,$db->f("pmessid"));
      $pquery["pmessid"] =  $db->f("pmessid");
      $bx->box_column("center","",$bgcolor,html_link("pmess_show.php",$pquery,$db->f("pmesssubject")));
      $bx->box_column("center","",$bgcolor,$db->f("username"));
      $timestamp = mktimestamp($db->f("pmesstime"));
      
      $bx->box_column("center","",$bgcolor,timestr_short($timestamp));
      $tasktype=$db->f("tasktype");
      if ($tasktype != "other") 
        {
         $db2->query("SELECT * FROM prog_abilities WHERE translation='$la' AND code='$tasktype'");
         $db2->next_record();
         $tasktype = $db2->f("ability");
        }
      $bx->box_column("center","",$bgcolor,$tasktype);
      $category=$db->f("category");
      switch($category) 
        {
         case "member":
         $bx->box_column("center","", $bgcolor,$t->translate("new project member"));
         break;
         case "task":
         $bx->box_column("center","", $bgcolor,$t->translate("specific task"));
         break;
         case "help":
         $bx->box_column("center","", $bgcolor,$t->translate("help/assistance"));
         break;
         case "test":
         $bx->box_column("center","", $bgcolor,$t->translate("testing/debugging"));
         break;
        }
      $pmesslang=$db->f("language");
      $bx->box_column("center","",$bgcolor,get_lang($pmesslang));
      $bx->box_next_row_of_columns();
      $bgcolor = "#FFFFFF";
     
     }
    $bx->box_columns_end();
    $bx->box_body_end();
    $bx->box_end();
    $bs->box_strip($msg);
   */
  }
else
  {
   $db->query("SELECT * FROM pmessages WHERE pmessid='$pmessid'");
   $username= $auth->auth["uname"];
   if ($db->num_rows()==0)
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Error"));
      $bx->box_body_begin();
      echo $t->translate("No such request");
      $bx->box_body_end();
      $bx->box_end();

     }
   else
     {
      $db->next_record();
      $pmesssubject=$db->f("pmesssubject");
      //$bs->box_strip($t->translate("Show request"));
      $bx->box_begin();
      $bx->box_body_begin();
      $bx->box_columns_begin(2);
      $bx->box_colspan(2,"center",$th_strip_title_bgcolor,"<b><FONT SIZE=+2>".$pmesssubject."</FONT></b>","");
      $bgcolor = "#FFFFFF";

      $bx->box_next_row_of_columns();
      $bx->box_column("left","30%", $bgcolor,"<B>".$t->translate("Sender").":</B> &nbsp; ");
      $pmessfrom=$db->f("pmessfrom");
      $pmessfrom = ereg_replace ("mailto:","", $pmessfrom);
      $bx->box_column("left","70%", $bgcolor,$pmessfrom);
      

      $bx->box_next_row_of_columns();
      $bx->box_column("left","30%", $bgcolor,"<B>".$t->translate("Time").":</B> &nbsp; ");
      $timestamp = mktimestamp($db->f("pmesstime"));
      $bx->box_column("left","70%", $bgcolor, timestr_short($timestamp));
      
      $bx->box_next_row_of_columns();
      $bx->box_colspan(2,"center",$bgcolor,"<b>&nbsp;</b>","");
      $bgcolor = "#F0F0F0";
      
      $bx->box_next_row_of_columns();
      $pmessmessage=$db->f("pmessmessage");
      $bx->box_colspan(2,"left",$bgcolor,"<B>".$t->translate("Content").":</B> &nbsp;<BR>\n"."<PRE>".$pmessmessage."</PRE>");
      $bx->box_next_row_of_columns();
      
      $bgcolor = "#FFFFFF";
      $bx->box_colspan(2,"center",$bgcolor,html_form_action("pmess_edit.php",array(),"POST").html_form_hidden("pmessid", $pmessid ).html_form_submit($t->translate("Reply"),"").html_form_action("req_manage.php",array(),"POST").html_form_hidden("pmessid", $pmessid).html_form_hidden("option", "delete" ).html_form_submit($t->translate("Delete"),"") );
      $bx->box_next_row_of_columns();
      $bx->box_columns_end();
      $bx->box_body_end();
      $bx->box_end();

      $db->query("UPDATE pmessages SET pmessstatus='read' WHERE pmessid='$pmessid' AND pmessto='$username'");


      }
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
