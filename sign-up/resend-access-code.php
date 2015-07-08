<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$last_sms_delivery = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $segment->get('pin_generate_time'));
$diff = $last_sms_delivery->diffInSeconds(\Carbon\Carbon::now(), false);

if ($diff > 120) {
	//check phone number and access code present
	if ($segment->get('phone_number') != '' && $segment->get('pin') != '') {

		$pin = $segment->get('pin');

		//send access code by SMS

		$getQuery = 'http://www.smsalertbox.com/api/sms.php?';
		$getQuery .= 'uid=' . getenv('UID');
		$getQuery .= '&pin=' . getenv('PIN');
		$getQuery .= '&sender=' . getenv('SENDER');
		$getQuery .= '&route=' . getenv('ROUTE');
		$getQuery .= '&tempid=' . 36978;
		$getQuery .= '&mobile=' . $segment->get('phone_number');
		$getQuery .= '&message=' . urlencode(' Dear customer your access code is ' . strtoupper($pin) . '.Thank You.');
		$getQuery .= '&pushid=' . getenv('PUSHID');

		$client = new GuzzleHttp\Client(['base_uri' => 'http://www.smsalertbox.com/api/sms.php']);
		$response = $client->get($getQuery);

		$segment->set('pin_generate_time', \Carbon\Carbon::now());

		$segment->setFlash('message', 'PIN is sent');

		//redirect to plan selection
		header('Location: ' . Config::$site_url . 'temp-login.php');

	} else {

		$session->destroy();
		header('Location: ' . Config::$site_url);
	}

} else {
	$wait = \Carbon\Carbon::now()->diffInSeconds($last_sms_delivery->addSeconds(120), false);
	$segment->setFlash('message', 'Wait ' . $wait . ' secs and retry');
	header('Location: ' . Config::$site_url . 'temp-login.php');
}

//http://www.smsalertbox.com/api/sms.php