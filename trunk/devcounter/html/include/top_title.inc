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
# Shows a bar with a title at top of page
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: top_title.inc,v 1.1 2002/08/26 12:54:20 helix Exp $
#
######################################################################  

?>

<!-- top title -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%" valign="center" >
<tr VALIGN=TOP BGCOLOR="<?php echo $th_nav_bgcolor;?>">
<td BGCOLOR="<?php echo $th_body_bgcolor;?>"><a href="<?php echo $sys_url_title;?>"><img SRC="<?php echo $sys_logo_image;?>" HSPACE=5 VSPACE=5 BORDER=0 height=<?php echo $sys_logo_heigth;?> width=<?php echo $sys_logo_width;?> ALT="<?php echo $sys_logo_alt;?>"></a></td>
<td WIDTH="10"><img SRC="images/blank.gif" BORDER=0 height=1 width=10></td>
<td VALIGN="middle" WIDTH="99%"><font color="<?php echo $th_nav_font_color;?>"><b><font size=+1><?php echo $sys_name;?></font></b>
<br><?php echo $sys_title;?></font></td>

<!-- logo at right -->
<td VALIGN="middle">
<a href="<?php echo $org_url;?>" TARGET="_blank"><img SRC="<?php echo $org_logo_image;?>" ALT="<?php echo $org_logo_alt;?>" HSPACE=10 BORDER=0 height=<?php echo $org_logo_heigth;?> width=<?php echo $org_logo_width;?> align=RIGHT></a></td>
</tr>
<!-- end logo at right -->

<tr>
<td COLSPAN="4" BGCOLOR="<?php echo $th_navstrip_bgcolor;?>"><img SRC="images/blank.gif" height=2 width=2></td>
</tr>
</table>
<!-- end top title -->