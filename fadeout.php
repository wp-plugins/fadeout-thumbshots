<?php
/*
Plugin Name: FadeOut-Thumbshots
Plugin URI: http://www.mynakedgirlfriend.de/wordpress/fadeout-thumbshots/
Description: 
Author: Thomas Schulte
Version: 1.2
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
if($version == '') {
	add_option('ts_fadeout_version','1.2','Version of the plugin FadeOut-Thumbshots','yes');
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

		echo('<div id="message" class="updated fade"><p><strong>Your options were saved.</strong></p></div>');
	}

	$active = get_option('ts_fadeout_active');
	$preview = get_option('ts_fadeout_preview');
	$showfooter = get_option('ts_fadeout_showfooter');
  
	echo('<div class="wrap">');
	echo('<form method="post" accept-charset="utf-8">');
    
	echo('<h2>FadeOut-Thumbshots Options</h2>');
	echo('<ol>');
	echo('<li>Set the option "Plugin active" to "no" if you don\'t want to show tooltips, this way you shouldn\'t deactivate the plugin in case you don\'t want to show the tooltips for a while.</li>');
	echo('<li>Tooltips can be used for three types of links. "All" just means all links that exist on a page and "external" hides the thumbshots for internal links.</li>');
	echo('<li>Using the option value "marked" means, that the tooltip-thumbshots are only shown if a link has a style class named "fadeout".</li>');
	echo('<li>Although it\'s up to you to decide whether you\'d like to place a backlink on your site or not, the Fadeout homepage says that using their thumbshots requires a backlink to their site.</li>');
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
				<td>show plugin info in footer:&nbsp;</td>
				<td>
					<select name="showfooter" id="showfooter">
						<option value="yes" label="yes"'); if ($showfooter == 'yes') echo(' selected=selected'); echo('>yes</option>
						<option value="no" label="no"'); if ($showfooter == 'no') echo(' selected=selected'); echo('>no</option>
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
	$header.= '<link rel="stylesheet" href="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/css/style.css" />' . "\n";

	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/lib/jquery.js"></script>' . "\n";
	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/lib/jquery.bgiframe.js"></script>' . "\n";
	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/lib/jquery.dimensions.js"></script>' . "\n";
	$header.= '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/fadeout-thumbshots/jquery-tooltip/jquery.tooltip.js"></script>' . "\n";

	$header.= '
		<script type="text/javascript">
			$(document).ready(function(){
				$(function() {';

					if(get_option('ts_fadeout_preview') == 'all') {

						$header.= '$("a").tooltip({';

					}else if(get_option('ts_fadeout_preview') == 'external') {
				
						$header.= 'for (var i = 0; i < document.links.length; ++i) {
							var link = document.links[i];
							var blogurl = "' . get_option("siteurl") . '";
							var linkurl = String(link.href).substring(0, blogurl.length);
							if(blogurl != linkurl) {
								link.className=link.className + " fadeout";
							}
						};';

						$header.= '$(".fadeout").tooltip({';

					}else if(get_option('ts_fadeout_preview') == 'marked') {

						$header.= '$(".fadeout").tooltip({';

					}


					$header.= '
						track: true,
						delay: 40,
						showURL: false,
						fixPNG: true,
						extraClass: "pretty",
						top: -15,
						left: 5,
						fade: 250,
						bodyHandler: function() {
							image = "http://fadeout.de/thumbshot-pro/?scale=5&url=" + this;';
							$header.= 'return $("<img />").attr("src", image);';

						$header.= '}
					});
				});
			});
		</script>';

	print($header);
}


function ts_fadeout_footer() {
	$footer.= '<div style="text-align:center;"><a href="http://fadeout.de/"><img style="vertical-align:middle;" src="http://fadeout.de/images/banner-80x15.gif"></a>&nbsp;Plugin by <a href="http://www.mynakedgirlfriend.de">MyNakedGirlfriend.de</a></div>';
	print($footer);
}

?>

