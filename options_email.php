<?php set_sms_defaults(); ?>
<div class="wrap">
<h2>SMS Notification Options | Email</h2>

<p>This option sends an email from your web server. Your server must be properly configured to send emails for this to work.  <br />
	<strong>If you don't know how to configure your server, I highly recommend you install and configuyre the <a href="http://wordpress.org/extend/plugins/configure-smtp/">Configure SMTP</a> plugin.</strong> 
	</p>

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

	<tr valign="top"><th scope="row">Send Email to:  (email address)</th>
		<td><input name="smsnotifications[email_to]" type="text" value="<?php echo $options['email_to'] ?>" />eg: username@domain.com. Note: This may be overridden if you send email through a SMTP server</td>
	</tr>
	<tr valign="top"><th scope="row"><strong>Note:</strong></th><td><strong>Note: the next two options might not work - it all depends on how your email is set up (your mail server might over-ride the From name and email address).</strong></td></tr>
	<tr valign="top"><th scope="row">Email appears to come from:  (email address)</th>
		<td><input name="smsnotifications[email_from]" type="text" value="<?php echo $options['email_from'] ?>" />eg: username@domain.com. Note: This may be overridden if you send email through a SMTP server</td>
	</tr>
	<tr valign="top"><th scope="row">Email appears to come from (Name)</th>
		<td><input name="smsnotifications[email_from_name]" type="text" value="<?php echo $options['email_from_name'] ?>" />eg: John Doe</td>
	</tr>
	<tr valign="top"><th scope="row">Message to send</th>
		<td><input type="text" name="smsnotifications[sms_message]" value="<?php echo $options['sms_message']; ?>" maxlength="140" size="140" />Message you want to email.</td>
	</tr>
	</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>