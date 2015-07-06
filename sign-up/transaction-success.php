<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Transaction Successful",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'errors' => $err,

);

$session->destroy();

echo $blade->view()->make('sign-up.success', $data);