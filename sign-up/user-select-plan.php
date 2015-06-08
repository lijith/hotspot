<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";
include_once "settings.php";

// $radgroupreply = $capsule::table('radgroupreply')
// 	->distinct()
// 	->select('groupname');

// $oval_plans = $capsule::table('radgroupcheck')
// 	->union($radgroupreply)
// 	->select('groupname')
// 	->distinct()
// 	->get();

$oval_plans = $capsule::table('couponplans')
	->where('price', '>', 0)
	->orderBy('price', 'ASC')
	->get();

foreach ($oval_plans as $key => $plan) {
	$oval_plans[$key]['id'] = $hashids->encode($plan['id']);
}

$form_data = array(
	'phone-number' => '',
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$segment->set('user_plan', trim($_POST['user-plan']));

	//redirect to plan selection
	header('Location: ' . Config::$site_url . 'check-out.php');

}

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Select Your Plan",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
	'plans' => $oval_plans,
);

echo $blade->view()->make('sign-up.select-plan', $data);