<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

$ccavenue = new \Ccavenue\CCAvenue;
$aes = new \Ccavenue\AESCrypt;

if ($segment->get('user_plan') != '' && $segment->get('phone_number') != '') {

	$plan = $capsule::table('couponplans')
		->where('id', '=', $hashids->decode($segment->get('user_plan')))
		->first();

	$order_id = 'OvalWiFi-' . \Carbon\Carbon::now()->format('YMd-Hi');
	$merchant_id = getenv('CCAVENUE_MERCHANT_KEY');
	$amount = $plan['price'];
	$url = urlencode(Config::$site_url . 'confirm-payment.php');
	$url_cancel = urlencode(Config::$site_url . 'cancel.php');
	$working_key = getenv('CCAVENUE_WORKING_KEY');
	$access_code = getenv('CCAVENUE_ACCESS_CODE');

	$merchant_data = '';
	$merchant_data .= 'tid=' . $segment->get('tid');
	$merchant_data .= '&merchant_id=' . $merchant_id;
	$merchant_data .= '&order_id=' . $order_id;
	$merchant_data .= '&amount=' . $amount;
	$merchant_data .= '&currency=' . 'INR';
	$merchant_data .= '&redirect_url=' . $url;
	$merchant_data .= '&cancel_url=' . $url_cancel;
	$merchant_data .= '&language=' . 'EN';
	$merchant_data .= '&customer_identifier=' . $segment->get('phone_number');

	// $merchant_data .= '&billing_name=""';
	// $merchant_data .= '&billing_address=""';
	// $merchant_data .= '&billing_city=""';
	// $merchant_data .= '&billing_state=""';
	// $merchant_data .= '&billing_zip=""';
	// $merchant_data .= '&billing_country=""';
	// $merchant_data .= '&billing_tel=""';
	// $merchant_data .= '&billing_email=""';
	// $merchant_data .= '&delivery_name=""';
	// $merchant_data .= '&delivery_address=""';
	// $merchant_data .= '&delivery_city=""';
	// $merchant_data .= '&delivery_state=""';
	// $merchant_data .= '&delivery_zip=""';
	// $merchant_data .= '&delivery_country=""';
	// $merchant_data .= '&delivery_tel=""';
	// $merchant_data .= '&merchant_param1=""';
	// $merchant_data .= '&merchant_param2=""';
	// $merchant_data .= '&merchant_param3=""';
	// $merchant_data .= '&merchant_param4=""';
	// $merchant_data .= '&merchant_param5=""';
	// $merchant_data .= '&promo_code=""';

	$encrypted = $aes->encrypt($merchant_data, $working_key);
	// var_dump($encrypted);
	// die;

	// echo $merchant_data;
	// die;

} else {
	header('Location: ' . Config::$site_url);
}

$form_data = array(
	'Order_Id' => $order_id,
	'Amount' => $plan['price'],
	'Merchant_Id' => $merchant_id,
	'encrypted' => $encrypted,
	'access_code' => $access_code,
);

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Select Your Plan",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
	'plan' => $plan,
);

echo $blade->view()->make('sign-up.check-out', $data);