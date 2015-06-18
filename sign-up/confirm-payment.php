<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$ccavenue = new \Ccavenue\CCAvenue;
$aes = new \Ccavenue\AESCrypt;

$encResponse = $_POST['encResp'];
$workingKey = getenv('CCAVENUE_WORKING_KEY');

$decrypted_response = $aes->decrypt($encResponse, $workingKey);

$ResponseBreakUp = explode('&', $decrypted_response);

$dataSize = sizeof($ResponseBreakUp);

for ($i = 0; $i < $dataSize; $i++) {
	$information = explode('=', $ResponseBreakUp[$i]);
	if ($i == 0) {
		$MerchantId = $information[1];
	}

	if ($i == 1) {
		$OrderId = $information[1];
	}

	if ($i == 2) {
		$Amount = $information[1];
	}

	if ($i == 3) {
		$AuthDesc = $information[1];
	}

	if ($i == 4) {
		$Checksum = $information[1];
	}

}

/*
 *
 * non encrypted response
 *
 * */
// $MerchantId = $_POST['Merchant_Id'];
// $OrderId = $_POST['Order_Id'];
// $Amount = $_POST['Amount'];
// $AuthDesc = $_POST['AuthDesc'];
// $workingKey = getenv('CCCAVENUE_WORKING_KEY');
// $Checksum = $_POST['Checksum'];

//process return
//from the gateway and find status
// $ResponseString = $MerchantId . '|' . $OrderId . '|' . $Amount . '|' . $AuthDesc . '|' . $workingKey;
// $ResponseChecksum = $ccavenue->genchecksum($ResponseString);
// $ChecksumStatus = $ccavenue->verifyChecksum($ResponseChecksum, $Checksum);

if ($AuthDesc === "Success") {
	//Successful Transaction
	//send generate username password and send sms

	//if valid sessions present
	if ($segment->get('user_plan') != '' && $segment->get('phone_number') != '') {

		$phone_number = $segment->get('phone_number');
		$plan = $capsule::table('couponplans')
			->where('id', '=', $hashids->decode($segment->get('user_plan')))
			->first();

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

			$segment->set('payment_status', 'success');
			header('Location: ' . Config::$site_url . 'transaction-success.php?username=' . $username . '&password=' . $password);
		}

	} else {
		header('Location: ' . Config::$site_url);
	}

	echo 'success';

} elseif ($AuthDesc === "Aborted") {
	//Pending Transaction
	echo 'Canceled';

} elseif ($AuthDesc === "Failure") {
	//Failed Transaction
	//Redirect to check-out page

	echo 'failed';

} else {
	echo 'something wrong in : server response = ' . $AuthDesc;
}
