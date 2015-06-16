<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";

// Import the necessary classes
use Aura\Session\SessionFactory;
use Philo\Blade\Blade;
use RandomLib\Factory as PasswordFactory;

//manage session
$session_factory = new SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$segment = $session->getSegment('oval/signup');

//manage password generation
$factory = new PasswordFactory;
$generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
$pasword_characters = 'abcdefghijklmnopqrstuvwxyz';

//front-end view
$views = __DIR__ . '../../views';
$cache = __DIR__ . '../../cache';
$blade = new Blade($views, $cache);

$form_data = array(
	'phone-number' => '',
);

$err = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$form_data['phone-number'] = $_POST['phone-number'];

	if (isset($_POST['phone-number']) && strlen(trim($_POST['phone-number'])) > 9) {

		if (is_numeric($_POST['phone-number'])) {

			//generate an access key and store in session with number
			//send access code to the phone number by sms
			//redirect to validate access key page

			$access_key = $generator->generateString(4, $pasword_characters);

			//connect to sms api
			$client = new GuzzleHttp\Client(['base_uri' => 'http://www.smsalertbox.com/api/sms.php']);
			$getQuery = 'http://www.smsalertbox.com/api/sms.php?' .
			$getQuery .= 'uid=' . getenv('UID');
			$getQuery .= '&pin=' . getenv('PIN');
			$getQuery .= '&sender=' . getenv('SENDER');
			$getQuery .= '&route=' . getenv('ROUTE');
			$getQuery .= '&tempid=' . getenv('TEMPID');
			$getQuery .= '&mobile=' . $_POST['phone-number'];
			$getQuery .= '&message=' . urlencode('Dear customer your access code is ' . $access_key);
			$getQuery .= '&pushid=1' . getenv('PUSHID');

			echo $getQuery;

			$response = $client->get($getQuery);

			die();

			//set access code to session
			$segment->set('access_code', $access_key);
			$segment->set('phone_number', trim($_POST['phone-number']));

			header('Location: ' . Config::$site_url . 'verify-access-code.php');

		} else {
			array_push($err, 'Phone number is not valid');
		}

	} else {
		array_push($err, 'please enter 10 digit phone number');
	}

}

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Free Sign-up for 30mins",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
);

echo $blade->view()->make('sign-up.free-signup', $data);