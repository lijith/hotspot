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

	$order_id = 'OvalWiFi' . \Carbon\Carbon::now()->format('YMd');
	$merchant_id = 'M_eshopsbg_6774';
	$amount = $plan['price'];
	$url = 'http://hotspot.dev/';
	$working_key = 'JKpJPyTJFWRFqvUQEXSeIxGBVKLqGixA';

	$billing_cust_name = '';
	$billing_cust_address = '';
	$billing_cust_country = '';
	$billing_cust_state = '';
	$billing_city = '';
	$billing_zip = '';
	$billing_cust_tel = '';
	$billing_cust_email = '';
	$delivery_cust_name = '';
	$delivery_cust_address = '';
	$delivery_cust_country = '';
	$delivery_cust_state = '';
	$delivery_city = '';
	$delivery_zip = '';
	$delivery_cust_tel = '';
	$delivery_cust_notes = '';

	$checksum = $ccavenue->getchecksum($merchant_id, $amount, $order_id, $url, $working_key);

	$merchant_data = '';
	$merchant_data .= 'Merchant_Id=' . $merchant_id;
	$merchant_data .= '&Amount=' . $amount;
	$merchant_data .= '&Order_Id=' . $order_id;
	$merchant_data .= '&Redirect_Url=' . $url;
	$merchant_data .= '&billing_cust_name=' . $billing_cust_name;
	$merchant_data .= '&billing_cust_address=' . $billing_cust_address;
	$merchant_data .= '&billing_cust_country=' . $billing_cust_country;
	$merchant_data .= '&billing_cust_state=' . $billing_cust_state;
	$merchant_data .= '&billing_cust_city=' . $billing_city;
	$merchant_data .= '&billing_zip_code=' . $billing_zip;
	$merchant_data .= '&billing_cust_tel=' . $billing_cust_tel;
	$merchant_data .= '&billing_cust_email=' . $billing_cust_email;
	$merchant_data .= '&delivery_cust_name=' . $delivery_cust_name;
	$merchant_data .= '&delivery_cust_address=' . $delivery_cust_address;
	$merchant_data .= '&delivery_cust_country=' . $delivery_cust_country;
	$merchant_data .= '&delivery_cust_state=' . $delivery_cust_state;
	$merchant_data .= '&delivery_cust_city=' . $delivery_city;
	$merchant_data .= '&delivery_zip_code=' . $delivery_zip;
	$merchant_data .= '&delivery_cust_tel=' . $delivery_cust_tel;
	$merchant_data .= '&billing_cust_notes=' . $delivery_cust_notes;
	$merchant_data .= '&Checksum=' . $checksum;

	$encrypted = $aes->encrypt($merchant_data, $working_key);

	// echo $encrypted;
	// die;

} else {
	header('Location: ' . Config::$site_url);
}

$form_data = array(
	'Order_Id' => $order_id,
	'Amount' => $plan['price'],
	'Merchant_Id' => 'M_eshopsbg_6774',
	'cmd' => '_xclick',
	'business' => 'admin@sobg.org',
	'currency_code' => 'USD',
	'billing_cust_name' => '',
	'billing_cust_address' => '',
	'billing_cust_country' => '',
	'billing_cust_email' => '',
	'billing_cust_tel' => '',
	'item_name' => '',
	'amount' => '',
	'shipping' => '',
	'delivery_cust_name' => '',
	'delivery_cust_address' => '',
	'delivery_cust_country' => '',
	'delivery_cust_email' => '',
	'delivery_cust_tel' => '',
	'encrypted' => $encrypted,
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