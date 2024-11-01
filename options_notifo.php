<?php set_sms_defaults(); ?>
<div class="wrap">
<h2>SMS Notification Options | Notifo</h2>

<p>Notifo allows Push notifications to be sent to any device with the Notifo application installed, including your computer or many smart phones like the iPhone.  Notifo is free for 'users' - provided you use this for personal use it's free for you. You do need to set up a free account. <br />
	</p>
	<p><strong>To use this service, please <a href="https://notifo.com/register">sign up for a Notifo account</a>. You will need to enter your Notifo username below. Also, make sure you have <a href="http://notifo.com/mobile_apps">installed the Notifo App</a> on your device of choice.</strong></p>
	<?php
		if ($_REQUEST['sendtestmessage']=="true") {
			include("notifo_api.php");
			$notifo = new Notifo_API($options['notifo_username'], $options['notifo_api_secret']);
			$params = array(
					"title"=>"SMS Notification",
					"msg"=>$options['sms_message']);
			$response = $notifo->send_notification($params);
			echo($response);
		}
	?>
<?php
	if ($options['notifo_username'] && $options['notifo_api_secret']) {
		?>
		<a href="<?php echo("/wp-admin/options-general.php?page=sms-notifications&sendtestmessage=true"); ?>">Send Test Message</a>
		<?php 
	} else {
?>

	<h2>Steps to Configure Notifo:</h2>
	<ol>
		<li><a href="https://notifo.com/register">Create a Notifo account</a></li>
		<li>Install the <a href="http://notifo.com/mobile_apps">Notifo App</a></li>
		<li>Get your <a href="http://notifo.com/user/settings">API Username and API Secret</a></li>
		<li>Fill in your API Username and API Secret below</li>
	</ol>
<?php }?>

<form method="post" action="options.php" >
	<?php settings_fields('smsnotifications_options'); ?>

	<table class="form-table">

	<tr valign="top"><th scope="row">Change Notification Method</th>
		<td><input type="radio" name="smsnotifications[notification_method]" value="bulksms" <?php checked('bulksms', $options['notification_method']); ?> >BulkSMS<br />
			<input type="radio" name="smsnotifications[notification_method]" value="notifo" <?php checked('notifo', $options['notification_method']); ?>>Notifo | Send Push notifications to your computer/mobile phone for free (<a href="http://notifo.com/">info</a>) | <i>This is the service you are currently using </i></i><br />
		<input type="radio" name="smsnotifications[notification_method]" value="email" <?php checked('email', $options['notification_method']); ?>>Email | <i>Send notifications to an email address (may require server configuration)</i></td>
	</tr>

	<tr valign="top"><th scope="row">Use [[SMS_NOTIFY]]</th>
		<td><input name="smsnotifications[notify_sms_notify_tag]" type="checkbox" value="1" <?php checked('1', $options['notify_sms_notify_tag']); ?> /> add this tag in posts or pages to be notified when the tag loads <strong>(you need to turn this on for the plugin to work!)</strong></td>
	</tr>
	<tr valign="top"><th scope="row">Notifo Username</th>
		<td><input type="text" name="smsnotifications[notifo_username]" value="<?php echo $options['notifo_username']; ?>" maxlength="20" size="20" /><a href="http://notifo.com/user/settings">Find it Here</a></td>
	</tr>
	
	<tr valign="top"><th scope="row">Notifo API Secret</th>
		<td><input type="text" name="smsnotifications[notifo_api_secret]" value="<?php echo $options['notifo_api_secret']; ?>" maxlength="70" size="70" /><a href="http://notifo.com/user/settings">Find it here</a></td>
	</tr>
	

	<tr valign="top"><th scope="row">Message to send</th>
		<td><input type="text" name="smsnotifications[sms_message]" value="<?php echo $options['sms_message']; ?>" maxlength="140" size="140" /></td>
	</tr>
	</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>

<?PHP
function url_is($showlink = FALSE) {
	if ($_GET['page_id'])
		$query = 'page_id=' . $_GET['page_id'];
	else
		$query = 'p=' . $_GET['p'];
	$urlis = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?' . $query;
	if($showlink == TRUE)
		return '<a href="' . $urlis . '">' . $urlis . '</a>';
	else
		return $urlis;
}
?>