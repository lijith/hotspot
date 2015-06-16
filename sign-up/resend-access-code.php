<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$last_sms_delivery = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $segment->get('access_code_sent_time'));
$diff = $last_sms_delivery->diffInSeconds(\Carbon\Carbon::now(), false);

if ($diff > 120) {
	//check phone number and access code present
	if ($segment->get('phone_number') != '' && $segment->get('access_code') != '') {

		$access_key = $segment->get('access_code');

		//send access code by SMS

		$getQuery = 'http://www.smsalertbox.com/api/sms.php?';
		$getQuery .= 'uid=' . getenv('UID');
		$getQuery .= '&pin=' . getenv('PIN');
		$getQuery .= '&sender=' . getenv('SENDER');
		$getQuery .= '&route=' . getenv('ROUTE');
		$getQuery .= '&tempid=' . 36828;
		$getQuery .= '&mobile=' . $segment->get('phone_number');
		$getQuery .= '&message=' . urlencode('Dear customer your account has been created with username ' . $access_key . ' and password ' . $access_key . '. Thank you.');
		$getQuery .= '&pushid=' . getenv('PUSHID');

		$client = new GuzzleHttp\Client(['base_uri' => 'http://www.smsalertbox.com/api/sms.php']);
		$response = $client->get($getQuery);

		$segment->set('access_code_sent_time', \Carbon\Carbon::now());

		$segment->setFlash('message', 'Access code is sent');

		//redirect to plan selection
		header('Location: ' . Config::$site_url . 'verify-mobile-user.php');

	} else {

		$session->destroy();
		header('Location: ' . Config::$site_url);
	}
	//redirect to plan selection
	header('Location: ' . Config::$site_url . 'verify-mobile-user.php');
} else {
	$wait = \Carbon\Carbon::now()->diffInSeconds($last_sms_delivery->addSeconds(120), false);
	$segment->setFlash('message', 'Wait ' . $wait . ' secs and retry');
	header('Location: ' . Config::$site_url . 'verify-mobile-user.php');
}

//http://www.smsalertbox.com/api/sms.php