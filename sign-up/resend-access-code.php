<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

//check phone number and access code present
if ($segment->get('phone_number') != '' && $segment->get('access_code') != '') {

	$access_code = $segment->get('access_code');

	//send access code

	header('Location: ' . Config::$site_url . 'verify-access-code.php');

} else {

	$session->destroy();
	header('Location: ' . Config::$site_url);
}
//redirect to plan selection
header('Location: ' . Config::$site_url . 'verify-mobile-user.php');
