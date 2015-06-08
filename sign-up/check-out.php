<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

if ($segment->get('user_plan') != '' && $segment->get('phone_number') != '') {

	$plan = $capsule::table('couponplans')
		->where('id', '=', $hashids->decode($segment->get('user_plan')))
		->first();

	$order_id = 'OvalWiFi' . \Carbon\Carbon::now()->format('YMd');
} else {
	header('Location: ' . Config::$site_url . 'sign-up');
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