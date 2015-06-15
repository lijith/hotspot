<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";

// $httpAdapter = new \Ivory\HttpAdapter\FileGetContentsHttpAdapter();

// // Create the Yahoo Finance provider
// $yahooProvider = new \Swap\Provider\YahooFinanceProvider($httpAdapter);

// // Create Swap with the provider
// $swap = new \Swap\Swap($yahooProvider);

// $rate = $swap->quote('USD/INR');

// var_dump($rate);

// // 1.187220
// echo $rate . '<br />';

// 1.187220
//echo round($rate->getValue());
//
//
$url = 'http://www.smsalertbox.com/api/sms.php';

$client = new GuzzleHttp\Client(['base_uri' => 'http://www.smsalertbox.com/api/sms.php']);

$params = array(
	'uid' => '6f7074696d7573',
	'pin' => '51ecf45216b54',
	'sender' => 'sender',
	'route' => '1',
	'mobile' => '9048861832',
	'message' => 'testmessage',
);

$r = $client->post($url, $params);

var_dump($r);
