<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$form_data = array(
	'phone-number' => '',
);
//check phone number and access code present
if ($segment->get('phone_number') != '' && $segment->get('access_code') != '') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['access-code']) || strlen($_POST['access-code']) > 4 || strlen($_POST['access-code']) < 3) {
			array_push($err, 'Invalid Access Code.');
		} else {
			if ($_POST['access-code'] == $segment->get('access_code')) {
				//generate username password
				//get all the usernames in account
				$usernames = $capsule::table('radcheck')
					->select('username')
					->get();
				$current_users = array();
				foreach ($usernames as $users) {
					array_push($current_users, $users['username']);
				}

				//generate a unique username
				$username = $generator->generateString(6, $pasword_characters);
				while (in_array($username, $current_users)) {
					$username = $generator->generateString(6, $pasword_characters);
				}
				$password = $generator->generateString(6, $pasword_characters);

				$segment->set('username', $username);
				$segment->set('password', $password);

				//add username and password , groupname
				//
				$rad_insert = $capsule::table('radcheck')
					->insert(array(
						'username' => $username,
						'attribute' => 'Cleartext-Password',
						'op' => ':=',
						'value' => $password,
					));

				$usergrp_insert = $capsule::table('radusergroup')
					->insert(array(
						'username' => $username,
						'groupname' => getenv('FREE_PLAN_GROUP'),
						'priority' => '0',
					));

				//send access code by SMS
				$getQuery = 'http://www.smsalertbox.com/api/sms.php?';
				$getQuery .= 'uid=' . getenv('UID');
				$getQuery .= '&pin=' . getenv('PIN');
				$getQuery .= '&sender=' . getenv('SENDER');
				$getQuery .= '&route=' . getenv('ROUTE');
				$getQuery .= '&tempid=' . 36828;
				$getQuery .= '&mobile=' . $_POST['phone-number'];
				$getQuery .= '&message=' . urlencode('Dear customer your account has been created with username ' . $access_key . ' and password ' . $access_key . '. Thank you.');
				$getQuery .= '&pushid=' . getenv('PUSHID');

				$client = new GuzzleHttp\Client(['base_uri' => 'http://www.smsalertbox.com/api/sms.php']);
				$response = $client->get($getQuery);

				$segment->set('payment_status', 'success');
				header('Location: ' . Config::$site_url . 'transaction-success.php?username=' . $username . '&password=' . $password);

			} else {
				array_push($err, 'The Access Code is not valid');
			}
		}

	}
} else {

	$session->destroy();
	header('Location: ' . Config::$site_url_free);
}

$data = array(
	'site_url' => Config::$site_url_free,
	'page_title' => "Sign-Up for Wifi Access",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
);

echo $blade->view()->make('sign-up.verify-access-code', $data);