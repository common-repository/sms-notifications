=== SMS Notifications ===
Contributors: dholowiski
Donate link: http://teachmewp.com/sms_notifications/
Tags: sms, notification, phone, text, email
Requires at least: 2.7
Tested up to: 3.0.4
Stable tag: 0.3.1

This plugin will send you a notification via Email, Notifo (free push service) or SMS when a specified page or post is viewed. 

== Description ==

If you want to be notified of an important event, install and activate this plugin. Then you can insert [[SMS_NOTIFICATION]] on an important page or post. When that page or post is viewed by a user, a configurable message will be sent:

* To your cell phone as an SMS message, or

* An email can be sent to a user-configurable email address, or 

* A push notification sent to your iPhone, computer or other Notifo supported device. Notifo messages include the user's IP address and the page being requested.


The [[SMS_NOTIFICATION]] will not be seen by the user. The plugin does attempt to filter out search engine bots. 
Possible uses: 

*place on a sale confirmation page to be alerted whenever a product sells

*place in your resume, to be alerted when your resume is viewed

A BIG warning - a message will be sent every time [[SMS_NOTIFICATION]] shows up. The plugin does attempt to filter out bots, but it isn't perfect. This means that if a search engine spider accesses your site you will be sent an SMS. If a user hits reload 100 times, you will get 100 messages.  This is intended only for use on IMPORTANT pages (such as those mentioned above). 

In the future this plugin will include options for limiting the number of messages sent, but for now - be careful!

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the Plugin under Settings/SMS Notifications

== Frequently Asked Questions ==

= Does it cost anything to use this plugin? =

The Email and Notifo options won't cost you anything.

If you use the BulkSMS option, it does cost money. Currently you must buy credits on BulkSMS.COM to send messages. Your cell phone carrier may also charge you to receive messages - please check with them and make sure you have an appropriate text messaging plan.

= Why doesn't the email option work? =

This plugin uses your server to send email. You need to have the SMTP settings and smtp_port set in your PHP.INI. If you can't or don't want to change these settings, you can use a WordPress plugin like Configure SMTP, which also allows the email to be sent through Gmail. 

= Why does my site load slow when using the Email option? =

The notification email is sent when the footer loads. Currently, the page stops loading until the email is sent (which can take 10 seconds or more with Gmail). I'm trying to figure out a way around this, but for now this is a known issue. 

= Why BulkSMS.COM? =

BulkSMS.COM supports the majority of carriers in Canada and the U.S. Since I'm in Canada this was the most important one for me to implement. I am not affiliated with BulkSMS, nor do I receive any compensation from them. 

= What is Notifo.com? =

Notifo is a free service that allows push messages to be sent to any device with the Notifo application installed, including your iPhone or a desktop computer. More info can be found at notifo.com

= Do you support x SMS method? =

In the future I will be adding many paid and free SMS sending methods, including email and twitter, so stay tuned. 

= The plugin settings page says I have successfully authenticated, but I am not receiving messages =

Make sure you have entered your phone number properly. You need to enter your country code and your full phone number.  In North America, this should be 11 digits long - 1, plus your 3 digit area code plus your 7 digit number.

== Changelog ==

= 0.3.1

Corrected bug that caused message to be sent for every post/page

Now shows IP Address and Page requested in notifo messages

Does not send notifications for known bots

= 0.3.0

Added Notifo support. Push messages can now be sent via Notifo

Small amount of code refactoring

= 0.20

Added the option to send notifications via email

Fixed bug so a notification is now only sent once per page load

Small amount of code refactoring

= 0.10

Plugin created
