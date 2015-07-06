<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$form_data = array(
	'phone-number' => '',
);
//check phone number and access code present
if ($segment->get('phone_number') != '' && $segment->get('pin') != '') {

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

echo $blade->view()->make('sign-up.temp-login', $data);