<?php
/*
	Plugin Name: CMF-Ads-Widget
	Plugin URI: http://wiki.geekyhabitat.com/tiki-index.php?page=WP-CMF-Ads
	Version: 0.1
	Author: Stuart Ryan
	Author URI: http://www.secludedhabitat.com/
	Description: A plugin to display advertisements from CMF Ads. To log a bug please submit directly to the <a href="http://bugzilla.geekyhabitat.com">GeekyHabitat Bugzilla Bug Tracker</a>.
*/

/*  Copyright 2008  Stuart Ryan  (email : bugmin@geekyhabitat.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



function widget_cmf_adsPlugin_init() {
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ){
		return;
	}

	function widget_cmf_ads($args) {
		extract($args);
		$options = get_option('widget_cmf_ads');
		$title = empty($options['title']) ? 'CMF Ads' : $options['title'];
		$generated_code = $options['generated_code'];
						
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $generated_code;
		echo $after_widget;
	}
			
			

	function widget_cmf_ads_control() {
		$options = $newoptions = get_option('widget_cmf_ads');
		if ($_POST['cmf_ads-submit']) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['cmf_ads-title']));
			$newoptions['site_id'] = strip_tags(stripslashes($_POST['cmf_ads-site_id']));
			$newoptions['widget_style'] = strip_tags(stripslashes($_POST['cmf_ads_widget_style']));
			$newoptions['cmf_link'] = strip_tags(stripslashes($_POST['cmf_ads_cmf_link']));
			$newoptions['center'] = strip_tags(stripslashes($_POST['cmf_ads_center_widget']));
			
			if ($newoptions['widget_style'] == 1){
				$height = '125';
				$width = '125';
			} elseif ($newoptions['widget_style'] == 2) {
				$height = '150';
				$width = '125';
			} elseif ($newoptions['widget_style'] == 3) {
				$height = '125';
				$width = '250';
			} elseif ($newoptions['widget_style'] == 4) {
				$height = '125';
				$width = '375';
			} elseif ($newoptions['widget_style'] == 5) {
				$height = '250';
				$width = '125';
			} elseif ($newoptions['widget_style'] == 6) {
				$height = '375';
				$width = '125';
			} elseif ($newoptions['widget_style'] == 7) {
				$height = '250';
				$width = '250';
			} 
			
			if ($newoptions['center'] == '1') {
        $strCenter = " text-align: center;";
      } else {
        $strCenter = "";
      }
      $generatedcode = '<div id="CMF-Widget" style="margin: 5px auto 0 auto;'.$strCenter.' width: ' . $width . 'px;">';
			
			$generatedcode = $generatedcode . '<script type="text/javascript" src="http://www.cmfads.com/widget/cmf-v2.0.js?siteid=' . $newoptions['site_id'] . '&amp;width=' . $width . '&amp;height=' . $height . '"></script>';
			
			if (($newoptions['cmf_link'] == '1') && ($newoptions['widget_style'] != '2')) {
				$generatedcode = $generatedcode . '<p class="CMF-Advertise"><a href="http://www.cmfads.com/cp/site-advertise.php?id=' . $newoptions['site_id'] . '">Advertise via CMF Ads</a></p>';
			}
			

			$generatedcode = $generatedcode . '</div>';
			
			$newoptions['generated_code'] = $generatedcode;
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_cmf_ads', $options);
		}
		
		$site_id = $options['site_id'];
		$widget_style = $options['widget_style'];
		$title = $options['title'];
		$center = $options['center'];
		$cmf_link = $options['cmf_link'];
		
		echo '<div>';
		echo '<label for="cmf_ads-title" style="line-height:35px;display:block;">Widget Title: <input type="text" id="cmf_ads-title" name="cmf_ads-title" value="' . $title . '" /></label>';
		echo '<label for="cmf_ads-site_id" style="line-height:35px;display:block;">CMF Site ID: <input type="text" id="cmf_ads-site_id" name="cmf_ads-site_id" value="' . $site_id . '" size="8" /></label>';
		echo '<label for="cmf_ads_widget_style">Ad Style: </label><select id="cmf_ads_widget_style" name="cmf_ads_widget_style" size="1"><option value="1" ';
		selected('1', $widget_style);
		echo '>1x1 widget, no bottom bar</option><option value="2" ';
		selected('2', $widget_style);
		echo '>1x1 widget with bottom bar</option><option value="3" ';
		selected('3', $widget_style);
		echo '>2 across, 1 down</option>
		<option value="4" ';
		selected('4', $widget_style);
		echo '>3 across, 1 down</option>
		<option value="5" ';
		selected('5', $widget_style);
		echo '>1 across, 2 down</option>
		<option value="6" ';
		selected('6', $widget_style);
		echo '>1 across, 3 down</option>
		<option value="7" ';
		selected('7', $widget_style);
		echo '>2 across, 2 down</option></select>';
		echo '<p><label for="cmf_ads_cmf_link">Show Advertise with CMF link: </label><input type="checkbox"   id="cmf_ads_cmf_link" name="cmf_ads_cmf_link" value="1" ';
		checked('1', $cmf_link );
		echo '/></p>';
		echo '<p><label for="cmf_ads_center_widget">Centre Widget: </label><input type="checkbox"   id="cmf_ads_center_widget" name="cmf_ads_center_widget" value="1" ';
		checked('1', $center );
		echo '/></p>';
		echo '<input type="hidden" name="cmf_ads-submit" id="cmf_ads-submit" value="1" />';
		echo '</div>';
	}
	
	register_sidebar_widget('CMF Ads Widget', 'widget_cmf_ads');
	register_widget_control('CMF Ads Widget', 'widget_cmf_ads_control', 300, 300);
} 
add_action('widgets_init', 'widget_cmf_adsPlugin_init');
?>
