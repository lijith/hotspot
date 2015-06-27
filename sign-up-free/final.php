<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$form_data = array(
	'phone-number' => '',
);
//check phone number and access code present
if ($segment->get('phone_number') != '' && $segment->get('access_code') != '') {
	if ($segment->get('payment_status') == 'success') {

		$session->destroy();
		$data = array(
			'site_url' => Config::$site_url_free,
			'page_title' => "Sign-Up for Wifi Access",
			'name' => 'Sign-Up',
			'flash' => $segment->getFlash('message'),
			'form_data' => $form_data,
			'errors' => $err,
			'username' => $_GET['username'],
			'password' => $_GET['password'],
		);

		echo $blade->view()->make('sign-up.verify-access-code', $data);
	}
} else {

	$session->destroy();
	header('Location: ' . Config::$site_url_free);
}
