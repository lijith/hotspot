<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$form_data = array(
	'phone-number' => '',
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$form_data['phone-number'] = $_POST['phone-number'];

	if (isset($_POST['phone-number']) && strlen(trim($_POST['phone-number'])) > 9) {

		if (is_numeric($_POST['phone-number'])) {

			//save phone number to session
			$segment->set('phone_number', trim($_POST['phone-number']));

			//access code
			$access_key = $generator->generateString(4, $pasword_characters);
			$segment->set('access_code', $access_key);

			//send access code by SMS

			//redirect to plan selection
			header('Location: ' . Config::$site_url . 'verify-mobile-user.php');

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