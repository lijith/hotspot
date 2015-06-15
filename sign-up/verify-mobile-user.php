<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$form_data = array(
	'phone-number' => '',
);
echo $segment->get('access_code');
//check phone number and access code present
if ($segment->get('phone_number') != '' && $segment->get('access_code') != '') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['access-code']) || strlen($_POST['access-code']) > 4 || strlen($_POST['access-code']) < 3) {
			array_push($err, 'Invalid Access Code.');
		} else {
			if ($_POST['access-code'] == $segment->get('access_code')) {
				$segment->set('verified', true);
				header('Location: ' . Config::$site_url . 'user-select-plan.php');
			} else {
				array_push($err, 'The Access Code is not valid');
			}
		}

	}
} else {

	$session->destroy();
	header('Location: ' . Config::$site_url);
}

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Sign-Up for Wifi Access",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
);

echo $blade->view()->make('sign-up.verify-access-code', $data);