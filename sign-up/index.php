<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$form_data = array(
	'phone-number' => '',
);

$current_pins = array();

if ($segment->get('access_code_sent_time') != '') {
	header('Location: ' . Config::$site_url . 'verify-mobile-user.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$form_data['phone-number'] = $_POST['phone-number'];

	if (isset($_POST['phone-number']) && strlen(trim($_POST['phone-number'])) > 9) {

		if (is_numeric($_POST['phone-number'])) {

			//save phone number to session
			$segment->set('phone_number', trim($_POST['phone-number']));

			//access code
			// $access_key = $generator->generateString(4, $pasword_characters);
			// $segment->set('access_code_sent_time', \Carbon\Carbon::now());
			// $segment->set('access_code', $access_key);

			//Generat Unique PIN

			//get used pins from db
			$usernames = $capsule::table('radcheck')
				->select('username')
				->get();
			$current_pins = array();
			foreach ($usernames as $users) {
				array_push($current_pins, $users['username']);
			}

			//generate a pin ie not used
			$pin = $generator->generateString(6, $pasword_characters);
			if (!empty($current_pins)) {
				while (in_array($pin, $current_pins)) {
					$pin = $generator->generateString(6, $pasword_characters);
				}
			}

			//save pin, and generate time to session
			$segment->set('pin_generate_time', \Carbon\Carbon::now());
			$segment->set('pin', $pin);

			$getQuery = 'http://www.smsalertbox.com/api/sms.php?';
			$getQuery .= 'uid=' . getenv('UID');
			$getQuery .= '&pin=' . getenv('PIN');
			$getQuery .= '&sender=' . getenv('SENDER');
			$getQuery .= '&route=' . getenv('ROUTE');
			$getQuery .= '&tempid=' . 36978;
			$getQuery .= '&mobile=' . $_POST['phone-number'];
			$getQuery .= '&message=' . urlencode('Dear customer your access code is ' . strtoupper($pin) . '.Thank You.');
			$getQuery .= '&pushid=' . getenv('PUSHID');

			$client = new GuzzleHttp\Client(['base_uri' => 'http://www.smsalertbox.com/api/sms.php']);
			$response = $client->get($getQuery);

			//sent PIN in db
			$rad_insert = $capsule::table('radcheck')
				->insert(array(
					'username' => $pin,
					'attribute' => 'Auth-Type',
					'op' => ':=',
					'value' => 'Accept',
				));

			//set temp acces group
			$usergrp_insert = $capsule::table('radusergroup')
				->insert(array(
					'username' => $pin,
					'groupname' => getenv('TEMP_ACCESS_PLAN'),
					'priority' => '0',
				));

			//to login link, resend pin page
			header('Location: ' . Config::$site_url . 'temp-login.php');

		} else {
			array_push($err, 'Phone number is not valid');
		}

	} else {
		array_push($err, 'please enter 10 digit phone number');
	}

}

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Sign-Up for Wifi Access",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
);

echo $blade->view()->make('sign-up.free-signup', $data);