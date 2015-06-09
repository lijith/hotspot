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
	$plan = $capsule::table('couponplans')
		->where('id', '=', $hashids->decode($segment->get('user_plan')))
		->first();

	// var_dump($plan['planname']);
	// die;

	if ($payment_success) {

		//generate a username and password

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
				'groupname' => $plan['planname'],
				'priority' => '0',
			));

		if ($rad_insert && $usergrp_insert) {
			//send username and password thru sms
			//

			echo 'username : ' . $username . ' password : ' . $password;
		}

		//redirect to hotspot login page

	}

} else {
	header('Location: ' . Config::$site_url);
}
