<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fraunhofer.de)
#       Stefan Heinze (heinze@fokus.fraunhofer.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Verification procedure during registration
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: verify.php,v 1.5 2004/03/02 09:22:58 helix Exp $
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

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php
$db->query("SELECT perms FROM auth_user WHERE user_id='$confirm_hash'");
$db->next_record();

if ($db->f("perms") == "user") {
    $msg = $t->translate("Your account is active. Please login").".";
    $bx->box_full($t->translate("Verification of Registration"), $msg);
} else {
    $query = "UPDATE auth_user SET perms='user' WHERE user_id='$confirm_hash'";
    $db->query($query);

    if ($db->affected_rows() == 0) {
       $be->box_full($t->translate("Error"), $t->translate("Verification of Registration failed").":<br>$query<p>Please contact the <a href=\"mailto:heinze@fokus.fraunhofer.de\">webmaster</a>");
    } else {
       $msg = $t->translate("Your account is now activated. Please login").".";
       $bx->box_full($t->translate("Verification of Registration"), $msg);
    }
 }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
