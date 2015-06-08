<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$payment_success = true;

//process return
//from the gateway and find status

//if valid sessions present
if ($segment->get('user_plan') != '' && $segment->get('phone_number') != '') {

	$phone_number = $segment->get('phone_number');
	$plan = $plan = $capsule::table('couponplans')
		->where('id', '=', $hashids->decode($segment->get('user_plan')))
		->first();

	if ($payment_success) {

		//generate a username and password

		//get all the usernames in account
		$usernames = $plan = $capsule::table('radacct')
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

		//add username and password to radacct
		//

		//send username and password thru sms
		//

		//redirect to hotspot login page

	}

} else {
	header('Location: ' . Config::$site_url . 'sign-up');
}
