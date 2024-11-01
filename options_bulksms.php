<?php set_sms_defaults(); ?>
<div class="wrap">
<h2>SMS Notification Options | BulkSMS</h2>

<p>This plugin sends SMS messages through BulkSMS.com (more options coming soon). BulkSMS.com provides pay as you go SMS functionality. Before using this plugin you must <a href="http://usa.bulksms.com/">sign up for an account</a>. You receive 5 free credits, and more can be added with a credit card. </p>

<p><font color="red"><strong>WARNING: This plugin sends SMS message to your Cell phone. Depending on your plan, you may be charged for 
incoming text messages. You are responsible for any charges - please verify your text messaging plan before using this plugin!</strong></font></p>


<?php
	//if there is a username and password, get current credits
	//if authentication fails, tell the user!
	if ($options['bulksmscom_username'] && $options['bulksmscom_password']) {
		$current_balance = get_data('http://usa.bulksms.com:5567/eapi/user/get_credits/1/1.1?username=' . $options['bulksmscom_username'] . '&password=' . $options['bulksmscom_password'] . '');
		$return_code = trim(substr($current_balance, 0, strpos($current_balance, '|'))); //get everything before the | (ie the returned code)
		if ($return_code == '0') {
			echo ('<h3>Current BulkSMS.COM Balance: ' . substr($current_balance, strpos($current_balance, '|')+1) . ' credits. (This also means you have successfully authenticated with BulkSMS.COM)</h3>');
		} else {
			echo ('<h3>Error Validating Account. Check your Username and Password. Error reported was: <i>' . $current_balance . '</i></h3>');
		}
			
	} else {
			echo ('<h3>Account not verified. Please enter your username and password.</h3>');
	}
	


?>

<form method="post" action="options.php" >
	<?php settings_fields('smsnotifications_options'); ?>
	
	<table class="form-table">
	
	<tr valign="top"><th scope="row">Change Notification Method</th>
		<td><input type="radio" name="smsnotifications[notification_method]" value="bulksms" <?php checked('bulksms', $options['notification_method']); ?> >BulkSMS | <i>This is the service you are currently using </i><br />
		<input type="radio" name="smsnotifications[notification_method]" value="notifo" <?php checked('notifo', $options['notification_method']); ?>>Notifo | Send Push notifications to your computer/mobile phone for free (<a href="http://notifo.com/">info</a>)</i><br />
		<input type="radio" name="smsnotifications[notification_method]" value="email" <?php checked('email', $options['notification_method']); ?>>Email | <i>Send notifications to an email address (may require server configuration)</i></td>
	</tr>
	
	<tr valign="top"><th scope="row">Use [[SMS_NOTIFY]]</th>
		<td><input name="smsnotifications[notify_sms_notify_tag]" type="checkbox" value="1" <?php checked('1', $options['notify_sms_notify_tag']); ?> /> add this tag in posts or pages to be notified when the tag loads <strong>(you need to turn this on for the plugin to work!)</strong></td>
	</tr>
	<tr valign="top"><th scope="row">Debug Mode</th>
		<td><input name="smsnotifications[bulksmscom_debug]" type="checkbox" value="1" <?php checked('1', $options['bulksmscom_debug']); ?> />No messages will be sent</td>
	</tr>
	<tr valign="top"><th scope="row">Username</th>
		<td><input type="text" name="smsnotifications[bulksmscom_username]" value="<?php echo $options['bulksmscom_username']; ?>" />Your BulkSMS.com Username</td>
	</tr>
	<tr valign="top"><th scope="row">Password</th>
		<td><input type="password" name="smsnotifications[bulksmscom_password]" value="<?php echo $options['bulksmscom_password']; ?>" />Your BulkSMS.com Password</td>
	</tr>
	<tr valign="top"><th scope="row">Message Priority (1, 2, 3)</th>
		<td><input type="text" name="smsnotifications[bulksmscom_priority]" value="<?php echo $options['bulksmscom_priority']; ?>" />1 is the least expensive, 3 is the most expensive. Actual rates vary from country to country</td>
	</tr>
	<tr valign="top"><th scope="row">Cell Phone Number</th>
		<td><input type="text" name="smsnotifications[phonenum]" value="<?php echo $options['phonenum']; ?>" />Include country code and area code. Ex 15555555555. If you are in North America, this should be 11 digits long - 1, plus your 3 digit area code plus your 7 digit number.</td>
	</tr>
	<tr valign="top"><th scope="row">Message to send</th>
		<td><input type="text" name="smsnotifications[sms_message]" value="<?php echo $options['sms_message']; ?>" maxlength="140" size="140" />Message you want sent to your phone number. Maximum 140 characters</td>
	</tr>
	</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>