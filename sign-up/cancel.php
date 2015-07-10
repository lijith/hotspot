<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

array_push($err, 'TRANSACTION FAILED');

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Transaction Cancelled",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'errors' => $err,
);

echo $blade->view()->make('sign-up.cancel', $data);