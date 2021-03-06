<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ===============================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fraunhofer.de)
#       Stefan Heinze (heinze@fokus.fraunhofer.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# The PHP3 and PHPLib HTML library
# (you will find some examples at the end of this document)
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: html.inc,v 1.8 2003/11/12 14:18:09 helix Exp $
#
######################################################################

function html_link($address, $query, $text) {
    global $sess;
    
    // this functions supposes that the text parameter it gets is already translated!

    if (!isset($query) || empty($query)) {
        $output = "<a href=\"".$sess->url($address)."\">".$text."</a>\n";
    } else {
        $output = "<a href=\"".$sess->url($address)
             .$sess->add_query($query)."\">".$text."</a>\n";
    }
    
    return $output;
}

function htmlp_link($address, $query, $text) {
    print html_link( $address, $query, $text );
}
 
function html_anchor($name) {
    return ( "<a name=\"".$name."\"></a>\n" );
}

function htmlp_anchor($name) {
    print html_anchor( $name );
}

function html_image($file, $border, $width, $height, $alternate) {
    return ( "<img src=\"images/".$file."\" border=\""
             .$border."\" width=\"".$width."\" height=\""
             .$height."\" alt=\"".$alternate."\" title=\"".$alternate."\">" );
}

function htmlp_image($file, $border, $width, $height, $alternate) {
    print html_image( $file, $border, $width, $height, $alternate );
}

function html_form_action($file, $query, $type) {
    global $sess;
    
    if ($file == "PHP_SELF") {
        $output = "<form action=\"".$sess->self_url();
		if ($query != "") {
        	$output .= $sess->add_query($query);
		}
		$output .= "\" method=\"".$type."\">";

    } else {
        $output = "<form action=\"".$sess->url($file);
		if ($query != "") {
        	$output .= $sess->add_query($query);
		}
		$output .= "\" method=\"".$type."\">";
    }
    return($output);
}

function htmlp_form_action($file, $query, $type) {
    print html_form_action( $file, $query, $type );
}
        
function html_form_hidden($name, $value) {
    // FIXME: might be necessary to escape the value (and name) so that
    // FIXME: they do not contain any quotes
    return ( "<input type=\"hidden\" name=\"".$name
             ."\" value=\"".$value."\">");
}

function htmlp_form_hidden($name, $value) {
    print html_form_hidden( $name, $value );
}

function html_select($name) {
    return "<select name=\"".$name."\">\n";
}

function htmlp_select($name) {
    print html_select( $name );
}

function html_select_option($value,$selected,$text) {
    $output = "<option ";
    $output .= ( $selected ? "selected " : "" );
    $output .= "value=\"".$value."\">".$text."\n";
    return($output);
}

function htmlp_select_option($value,$selected,$text) {
    print html_select_option( $value, $selected, $text );
}

function html_select_end() {
    return "</select>\n";
}

function htmlp_select_end() {
    print html_select_end();
}

function html_input_text($name, $size, $maxlength, $value) {
    return ( "<input type=\"text\" name=\"".$name."\" size=\""
             .$size."\" maxlength=\"".$maxlength."\" value=\""
             .$value."\">\n" );
}

function htmlp_input_text($name, $size, $maxlength, $value) {
    print html_input_text( $name, $size, $maxlength, $value );
}

function html_input_password($name, $size, $maxlength, $value) {
    return ( "<input type=\"password\" name=\"".$name."\" size=\""
             .$size."\" maxlength=\"".$maxlength."\" value=\""
             .$value."\">\n" );
}

function htmlp_input_password($name, $size, $maxlength, $value) {
    print html_input_password( $name, $size, $maxlength, $value );
}

function html_form_submit($value,$name) {
    return "<input type=\"submit\" value=\"".$value."\" name=\"".$name."\">\n";
}

function htmlp_form_submit($value,$name) {
    print html_form_submit($value, $name );
}

function html_checkbox($name,$value,$checked) {
    $output = "<input type=\"checkbox\" name=\"".$name."\"";
    $output .= ( $checked ? " checked " : " " );
    $output .= "value=\"".$value."\"";
    return($output);
}

function htmlp_checkbox($name,$value,$checked) {
    print html_checkbox( $name, $value, $checked );
}

function html_radio($name,$value,$checked) {
    $output = "<input type=\"radio\" name=\"".$name."\"";
    $output .= ( $checked ? " checked " : " " );
    $output .= "value=\"".$value."\">";
    return($output);
}
function htmlp_radio($name,$value,$checked) {
    print html_radio( $name, $value, $checked );
}

function html_textarea($name,$columns,$rows,$wrap,$maxlength,$value) {

    return ("<textarea cols=\"".$columns."\" rows=\"".$rows."\" name=\""
            .$name."\" wrap=\"".$wrap."\" maxlength=\"".$maxlength."\">"
            .$value."</textarea>\n" );
}

function htmlp_textarea($name,$columns,$rows,$wrap,$maxlength,$value) {
    print html_textarea( $name, $columns, $rows, $wrap, $maxlength, $value );
}

function html_form_end() {
    return "</form>\n";
}

function htmlp_form_end() {
    print html_form_end();
}

?>
