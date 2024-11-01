<?PHP
//this code is based on the great example from planetozh.com - thanks!
//http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/

//first give a big warning if cURL doesnt exist
if (!function_exists('curl_init')) {
	echo ('<h1>WARNING: THE PHP CURL FUNCTION WAS NOT FOUND</h1><h1>You must Install or enable PHP:cURL before using this plugin!</h1>');
}
?>

<?php $options = get_option('smsnotifications'); ?>


<?PHP 
#only show this if a notification method has not been selected. 
#this should only be shown on new installations
if (!$options[notification_method]) {
?>
	<p>
	<strong>Please select a notification method</strong>
	<form method="post" action="options.php" >
	<?php settings_fields('smsnotifications_options'); ?>

	<table class="form-table">
		<tr valign="top"><th scope="row">Notification Method</th>
		<td><input type="radio" name="smsnotifications[notification_method]" value="notifo" <?php checked('notifo', $options['notification_method']); ?>>Notifo | Send Push notifications to your computer/mobile phone for free (<a href="http://notifo.com/">info</a>)</i><br />
		<input type="radio" name="smsnotifications[notification_method]" value="bulksms" <?php checked('bulksms', $options['notification_method']); ?> >BulkSMS | <i>This option uses BulkSMS.com which is a pay as you go sms service. A BulkSMS account is required. </i><br />
		<input type="radio" name="smsnotifications[notification_method]" value="email" <?php checked('email', $options['notification_method']); ?>>Email | <i>Send notifications to an email address (may require server configuration)</i></td>
		</tr>
	</table>
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	</form>
	</p>
<?PHP } ?>

<?php
if ($options[notification_method] == "email") {
	include('options_email.php');
}

if ($options[notification_method] == "bulksms")  { 
	include('options_bulksms.php');
}

if ($options[notification_method] == "notifo")  { 
	include('options_notifo.php');
}
?>