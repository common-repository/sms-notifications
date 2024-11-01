<?php
/*
Plugin Name: SMS Notifications
Plugin URI: http://teachmewp.com/sms_notifications
Description: Send SMS notifications on various events, or when a user configured short-code is loaded
Version: 0.3.1
Author: Dave Holowiski
Author URI: http://holowiski.com
License: GPL2
*/

/*  Copyright 2010  DAVE HOLOWISKI  (email : david@holowiski.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//this is the function code

register_activation_hook( __FILE__, 'smsnotifications_activate' );
add_action('admin_init', 'smsnotifications_init' );
//grab the options
$options = get_option('smsnotifications');
//and only add smsnotification_shortcode if the option is checked
if ($options['notify_sms_notify_tag']) {
	add_filter ( 'the_content', 'smsnotification_shortcode');
}
add_action('admin_menu', 'my_plugin_menu');

add_action ('wp_footer', 'email_in_footer');
function email_in_footer() {
		$options = get_option('smsnotifications');
	//global $please_notify_me;
	if ($options[to_be_notified] == "yes") {
		notify_me();
	}
}

//now for the functions...
function smsnotifications_activate() {
	//this runs when the plugin is activated
	$options = get_option('smsnotifications');
	//set some important defaults, if they havent been set already
	if (!$options['notify_sms_notify_tag']) {
		$options['notify_sms_notify_tag'] = "1"; //turn the tag notification on
	}
	if (!$options['bulksmscom_priority']) {
		$options['bulksmscom_priority'] = "1"; //set the default priority to 1
	}
	if (!$options['sms_message']) {
		$options['sms_message'] = "A [[SMS_NOTIFICATION]] has occured";//the default SMS message
	}
	if ($options['bulksmscom_username']) {
		//if there is already a bulksms username, set notification to bulksms
		//this is required for users who upgrade.
		$options['notification_method'] = "bulksms";
	}
	update_option('smsnotifications', $options);
	
}

function set_sms_defaults() {
	$options = get_option('smsnotifications');
	//set some important defaults, if they havent been set already
	if (!$options['notify_sms_notify_tag']) {
		$options['notify_sms_notify_tag'] = "1"; //turn the tag notification on
	}
	if (!$options['bulksmscom_priority']) {
		$options['bulksmscom_priority'] = "1"; //set the default priority to 1
	}
	if (!$options['sms_message']) {
		$options['sms_message'] = "A [[SMS_NOTIFICATION]] has occured";//the default SMS message
	}
	if ($options['bulksmscom_username']) {
		//if there is already a bulksms username, set notification to bulksms
		//this is required for users who upgrade.
		$options['notification_method'] = "bulksms";
	}
	update_option('smsnotifications', $options);
}

function smsnotifications_init() {
	//this runs when the admin section is accessed... i think
	register_setting( 'smsnotifications_options', 'smsnotifications');
}

function smsnotification_shortcode($content) {
	$options = get_option('smsnotifications');
	//look for the short-code [[SMS_NOTIFY]], and send SMS if it exists
	if (strpos ($content, '[[SMS_NOTIFY]]')) {
		$options[to_be_notified] = "yes";
		update_option('smsnotifications', $options);
	}
	//now remove the short-code [[SMS_NOTIFY]]
	$shortcode = array('[[SMS_NOTIFY]]'); //it's an array so i can easily add more codes later
	$content = str_ireplace($shortcode, '', $content);
	return $content;
}

function notify_me() {
	//get the plugin options, to pass them to send_sms
	if (!is_this_a_bot()) {
		$options = get_option('smsnotifications');
		if ($options['notification_method'] == "bulksms") {
			send_sms($options['bulksmscom_username'], $options['bulksmscom_password'], $options['phonenum'], $options['sms_message'], 										$options['bulksmscom_priority'], $options['bulksmscom_debug']);

			$options[to_be_notified] = "no";
			update_option('smsnotifications', $options);
		if ($options['notification_method'] == "email")
			$headers = 'From: '. $options['email_from_name'] .' <'. $options['email_from'] .'>' . "\r\n\\";
			wp_mail($options['email_to'], $options['sms_message'], $options['sms_message'], $headers);

			$options[to_be_notified] = "no";
			update_option('smsnotifications', $options);
		}
		if ($options['notification_method'] == "notifo") {
			include("notifo_api.php");
			$notifo = new Notifo_API($options['notifo_username'], $options['notifo_api_secret']);
			$params = array(
					"title"=>"SMS Notification",
					"msg"=>get_my_ip()."-".get_current_url()."-".$options['sms_message'], 
					"url"=> get_permalink());
				#print_r($_SERVER);
			$response = $notifo->send_notification($params);
			#echo(get_url());
			$options[to_be_notified] = "no";
			update_option('smsnotifications', $options);
		
		}
	}
}

/* gets the data from a URL */
function get_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function my_plugin_menu() {

  add_options_page('SMS Notifications Options', 'SMS Notifications', 'manage_options', 'sms-notifications', 'my_plugin_options');
}

function my_plugin_options() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

require( dirname( __FILE__ ) . '/options.php' );
}
//this file sets up the send_sms function
//this will eventually be a case statement for different sms providers

function send_sms($username, $password, $msisdn, $message, $routing_group, $test_always_succeed) {
require( dirname( __FILE__ ) . '/send_sms_bulksms.php' );
}

function get_url() {
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
	    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else 
	{
	    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function get_my_ip() {
	#assumes that $_SERVER is set. Return false if it isnt
	if (isset($_SERVER)) {
		#check if ip address was given. If not return false
		if (isset($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function get_current_url() {
	#assumes that $_SERVER is set. return false if not
	if (isset($_SERVER)) {
		if (isset($_SERVER['REQUEST_URI'])) {
			return $_SERVER['REQUEST_URI'];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function is_this_a_bot() {
	#this function checks the $_SERVER variables to see if the requestor is a search engine indexing you.
	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$botlist=array("teoma", "alexa", "froogle", "inktomi", "looksmart", "url_spider_sql", "firefly", "nationaldirectory", "ask jeeves", "tecnoseek", "infoseek", "webfindbot", "girafabot", "crawler", "www.galaxy.com", "googlebot", "scooter", "slurp", "appie", "fast", "webbug", "spade", "zyborg", "rabaz");
			foreach ($botlist as $bot) {
				#echo("bot ".$bot);
				#echo("user agent ".strtolower($_SERVER['HTTP_USER_AGENT']));
				if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $bot)) {
					return true;
				}
			}
		} else {
			#no HTTP_USER_AGENT given. Return false - not a bot
			return false;
		}
	} else {
		#no $_SERVER variable found. Return false.
		return false;
	}
}

?>
