<?php 
//This sets up the send_sms function using the BulkSMS.com API
//You need to register for a username and password, and you get 5 free credits
//Setting the Debug flag doesn't send SMS messages but tests everything else. 
//Routing group 1 is cheapest, 3 is most expensive

//This code comes just about verbatim from the BulkSMS.com example code
//	http://usa.bulksms.com/docs/eapi/code_samples/php/

$url = 'http://usa.bulksms.com/eapi/submission/send_sms/2/2.0';
$port = 80;
/*
* We recommend that you use port 5567 instead of port 80, but your
* firewall will probably block access to this port (see FAQ for more
* details):
* $port = 5567;
*/

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_PORT, $port);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$post_body = '';

$post_fields = array(
        username => $username,
        password => $password,
        message => $message,
        msisdn => $msisdn,
        routing_group => $routing_group,
        test_always_succeed => $test_always_succeed
);

foreach($post_fields as $key=>$value) {
        $post_body .= urlencode($key).'='.urlencode($value).'&';
}
$post_body = rtrim($post_body,'&');

# Do not supply $post_fields directly as an argument to CURLOPT_POSTFIELDS,
# despite what the PHP documentation suggests: cUrl will turn it into in a
# multipart formpost, which is not supported:
curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_body);
$response_string = curl_exec($ch);
$curl_info = curl_getinfo($ch);

/*
//To make this better, I should return a response message
//then if this fails, I can push a notification to the dashboard

if ($response_string == FALSE) {
        print "cURL error: ".curl_error($ch)."\n";
} elseif ($curl_info['http_code'] != 200) {
        print "Error: non-200 HTTP status code: ".$curl_info['http_code']."\n";
}
else {
        print "Response from server:$response_string\n";
        $result = split('\|', $response_string);
        if (count($result) != 3) {
                print "Error: could not parse valid return data from server.\n".count($result);
        } else {
                if ($result[0] == '0') {
                        print "Message sent - batch ID $result[2]\n";
                }
                else {
                        print "Error sending: status code [$result[0]] description [$result[1]]\n";
                }
        }
}
*/
curl_close($ch);
?>