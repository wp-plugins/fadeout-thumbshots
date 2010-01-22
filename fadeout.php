<?php
/*
Plugin Name: FadeOut-Thumbshots
Plugin URI: http://www.mynakedgirlfriend.de/wordpress/fadeout-thumbshots/
Description: This plugin dynamically shows a preview tooltip for hyperlinks on your WordPress site.
Author: Thomas Schulte
Version: 1.9
Author URI: http://www.mynakedgirlfriend.de

Copyright (C) 2010 Thomas Schulte

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/



$version = get_option('ts_fadeout_version');
if($version == '' || $version != "1.9") {
	add_option('ts_fadeout_version','1.9','Version of the plugin FadeOut-Thumbshots','yes');
}

$active = get_option('ts_fadeout_active');
if($active == '') {
	add_option('ts_fadeout_active','yes');
}

$preview = get_option('ts_fadeout_preview');
if($preview == '') {
	add_option('ts_fadeout_preview','all');
}

$showfooter = get_option('ts_fadeout_showfooter');
if($showfooter == '') {
	add_option('ts_fadeout_showfooter','yes');
}

$scaling = get_option('ts_fadeout_scaling');
if($scaling == '') {
	add_option('ts_fadeout_scaling','5');
}

$opacity = get_option('ts_fadeout_opacity'); 
if($opacity == '') {
	add_option('ts_fadeout_opacity','0.9');
}

$dummylang = get_option('ts_fadeout_dummylang');
if($dummylang == '') {
	add_option('ts_fadeout_dummylang','de');
}

/* actions */
add_action( 'admin_menu', 'ts_fadeout_options_page' ); // add option page

if(get_option('ts_fadeout_active') == 'yes') {
	add_action('plugins_loaded', 'ts_fadeout_add_plugin');
}


function ts_fadeout_add_plugin() {
	add_action('wp_head', 'ts_fadeout_header');
	if(get_option('ts_fadeout_showfooter') == 'yes') {
		add_action('wp_footer', 'ts_fadeout_footer');
	}
}

  
/* add option page */
function ts_fadeout_options_page() {
	if(function_exists('add_options_page')){
		add_options_page('FadeOut-Thumbshots','FadeOut-Thumbshots',8,'fadeout','ts_fadeout_options');
	}
}


/* the real option page */
function ts_fadeout_options(){
	if(isset($_POST['ts_fadeout_options_update'])) {
		$active = $_POST['active'];
		$preview = $_POST['preview'];
    		$showfooter = $_POST['showfooter'];
		$scaling = $_POST['scaling'];
		$opacity = $_POST['opacity'];
		$dummylang = $_POST['dummylang'];

		if($active == 'yes') {
			update_option('ts_fadeout_active','yes');
		}else {
			update_option('ts_fadeout_active','no');
		}

		if($preview == 'all') {
			update_option('ts_fadeout_preview','all');
		}elseif($preview == 'marked') {
			update_option('ts_fadeout_preview','marked');
		}elseif($preview == 'external') {
			update_option('ts_fadeout_preview','external');
		}

		if($showfooter == 'yes') {
			update_option('ts_fadeout_showfooter','yes');
		}else {
			update_option('ts_fadeout_showfooter','no');
		}

		if(in_array($scaling, array("2", "3", "4", "5", "6", "7", "8"))) {
			update_option('ts_fadeout_scaling',$scaling);
		}

		if(is_numeric($opacity)) {
			update_option('ts_fadeout_opacity',$opacity);
		}

		if(in_array($dummylang, array("en", "de"))) {
			update_option('ts_fadeout_dummylang',$dummylang);
		}

		echo('<div id="message" class="updated fade"><p><strong>Your options were saved.</strong></p></div>');
	}

	$active = get_option('ts_fadeout_active');
	$preview = get_option('ts_fadeout_preview');
	$showfooter = get_option('ts_fadeout_showfooter');
	$scaling = get_option('ts_fadeout_scaling');
	$opacity = get_option('ts_fadeout_opacity');
	$dummylang = get_option('ts_fadeout_dummylang');
  
	echo('<div class="wrap">');
	echo('<form method="post" accept-charset="utf-8">');
    
	echo('<h2>FadeOut-Thumbshots Options</h2>');
	echo('<ol>');
	echo('<li>Set the option "Plugin active" to "no" if you don\'t want to show tooltips, this way you shouldn\'t deactivate the plugin in case you don\'t want to show the tooltips for a while.</li>');
	echo('<li>Tooltips can be used for three types of links. "All" just means all links that exist on a page and "external" hides the thumbshots for internal links.</li>');
	echo('<li>Using the option value "marked" means, that the tooltip-thumbshots are only shown if a link has a style class named "fadeout".</li>');
	echo('<li>The opacity may be set according your needs. I prefer using "0.1", "0.2"... "1" to adjust the opacity.</li>');
	echo('<li>Although it\'s up to you to decide whether you\'d like to place a backlink on your site or not, the Fadeout homepage says that using their thumbshots requires a backlink to their site. You can enable/disable the footer info with the corresponding select field. The footer was developed very roughly, so if you like the plugin, please link the two domains <a href="http://www.fadeout.de">www.fadeout.de</a> and <a href="http://www.mynakedgirlfriend.de">www.mynakedgirlfriend.de</a> somewhere in your blog. Thanks!</li>');
	echo('</ol>');
	echo('<br>');
	echo('
		<h3>Settings</h3>
		<table>
			<tr>
				<td>Plugin active:&nbsp;</td>
				<td>
					<select name="active" id="active">  
						<option value="no" label="no"'); if ($active == 'no') echo(' selected=selected'); echo('>no</option>
						<option value="yes" label="yes"'); if ($active == 'yes') echo(' selected=selected'); echo('>yes</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>tooltip preview type:&nbsp;</td>
				<td>
					<select name="preview" id="preview">
						<option value="all" label="all"'); if ($preview == 'all') echo(' selected=selected'); echo('>all</option>
						<option value="external" label="external"'); if ($preview == 'external') echo(' selected=selected'); echo('>external</option>
						<option value="marked" label="marked"'); if ($preview == 'marked') echo(' selected=selected'); echo('>marked</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>tooltip preview size:&nbsp;</td>
				<td>
					<select name="scaling" id="scaling">
						<option value="2"'); if ($scaling == '2') echo(' selected=selected'); echo('>463 x 523</option>
						<option value="3"'); if ($scaling == '3') echo(' selected=selected'); echo('>343 x 373</option>
						<option value="4"'); if ($scaling == '4') echo(' selected=selected'); echo('>278 x 298</option>
						<option value="5"'); if ($scaling == '5') echo(' selected=selected'); echo('>241 x 253</option>
						<option value="6"'); if ($scaling == '6') echo(' selected=selected'); echo('>216 x 223</option>
						<option value="7"'); if ($scaling == '7') echo(' selected=selected'); echo('>198 x 201</option>
						<option value="8"'); if ($scaling == '8') echo(' selected=selected'); echo('>185 x 185</option>
					</select> Pixel
				</td>
			</tr>
			<tr>
				<td>show plugin info in footer:&nbsp;</td>
				<td>
					<select name="showfooter" id="showfooter">
						<option value="yes" label="yes"'); if ($showfooter == 'yes') echo(' selected=selected'); echo('>yes</option>
						<option value="no" label="no"'); if ($showfooter == 'no') echo(' selected=selected'); echo('>no</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>tooltip opacity:&nbsp;</td>
				<td>
					<input type="text" size="3" maxlength="3" name="opacity" value="' . $opacity . '">
				</td>
			</tr>
			<tr>
				<td>dummy lang:&nbsp;</td>
				<td>
					<select name="dummylang" id="dummylang">
						<option value="en" label="en"'); if ($dummylang == 'en') echo(' selected=selected'); echo('>english</option>
						<option value="de" label="de"'); if ($dummylang == 'de') echo(' selected=selected'); echo('>german</option>
					</select>
				</td>
			</tr>
		</table>');  
  
	echo('
		<p class="submit">
			<input type="hidden" name="action" value="update" />
			<input type="submit" name="ts_fadeout_options_update" value="Update Options &raquo;" />
		</p>');

	echo('</form>');
	echo('</div>');
}


function ts_fadeout_header() {
	$header.= '<link rel="stylesheet" href="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/jquery.tooltip.css" />' . "\n";

	$header.= '<style type="text/css">
		<!--
			#tooltip.pretty {
				font-family: Arial;
				border: none;';

				switch(get_option('ts_fadeout_scaling')) {
					case 2:
						$header.= 'width: 463px; height: 523px;';
						break;
					case 3:
						$header.= 'width: 343px; height: 373px;';
						break;
					case 4:
						$header.= 'width: 278px; height: 298px;';
						break;
					case 5:
						$header.= 'width: 241x; height: 253px;';
						break;
					case 6:
						$header.= 'width: 216px; height: 223px;';
						break;
					case 7:
						$header.= 'width: 198px; height: 201px;';
						break;
					case 8:
						$header.= 'width: 185px; height: 185px;';
						break;
				}

	$header.= '		padding:0px;
				opacity: ' . get_option("ts_fadeout_opacity") . ';
				background: url("' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/shadow-' . get_option('ts_fadeout_scaling') . '.png");
			}

			#tooltip.pretty div {
				text-align: left;';

				switch(get_option('ts_fadeout_scaling')) {
					case 2:
						$header.= 'width: 463px; padding-left: 38px; padding-top:32px;';
						break;
					case 3:
						$header.= 'width: 343px; padding-left:38px; padding-top:32px;';
						break;
					case 4:
						$header.= 'width: 278px; padding-left:38px; padding-top:32px;';
						break;
					case 5:
						$header.= 'width: 200px; padding-left:38px; padding-top:32px;';
						break;
					case 6:
						$header.= 'width: 216px; padding-left:38px; padding-top:32px;';
						break;
					case 7:
						$header.= 'width: 198px; padding-left:38px; padding-top:32px;';
						break;
					case 8:
						$header.= 'width: 185px; padding-left:38px; padding-top:32px;';
						break;
				}

	$header.= '}
		-->
		</style>';

	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/lib/jquery.js"></script>' . "\n";
	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/lib/jquery.bgiframe.js"></script>' . "\n";
	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/lib/jquery.dimensions.js"></script>' . "\n";
	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/jquery.tooltip.js"></script>' . "\n";

	$header.= '
		<script type="text/javascript">
			$(document).ready(function(){
				$(function() {';

					if(get_option('ts_fadeout_preview') == 'all' || get_option('ts_fadeout_preview') == 'external') {

						$header.= 'for (var i = 0; i < document.links.length; ++i) {
							var link = document.links[i];
							var blogurl = "' . get_option("siteurl") . '";
							var linkurl = String(link.href).substring(0, blogurl.length);
							var linkproto = String(link.href).substring(0, 4);

							if(linkproto == "http") {';

							if(get_option('ts_fadeout_preview') == 'external') {
								$header.= 'if(blogurl != linkurl) {
									link.className=link.className + " fadeout";
								}';
							}else {
								$header.= 'link.className=link.className + " fadeout";';
							}
						$header.= '}};';

					}

					$header.= '$(".fadeout").tooltip({
						track: true,
						delay: 40,
						showURL: false,
						fixPNG: true,
						extraClass: "pretty",
						top: -15,
						left: 5,
						fade: 250,
						bodyHandler: function() {
							image = "http://fadeout.de/thumbshot-pro/?scale=' . get_option('ts_fadeout_scaling') . '&url=" + this + "&wp=1&lang=' . get_option('ts_fadeout_dummylang') . '";
							return $("<img style=\"border: none;\" />").attr("src", image);';

						$header.= '}
					});
				});
			});
		</script>';

	print($header);
}


function ts_fadeout_footer() {
	$footer.= '<div style="text-align:center;"><a href="http://fadeout.de/"><img style="vertical-align:middle;" src="http://fadeout.de/images/link.gif" alt="FadeOut-Thumbshots"></a>&nbsp;Plugin by <a href="http://www.mynakedgirlfriend.de">MyNakedGirlfriend.de</a></div>';
	print($footer);
}

?>
