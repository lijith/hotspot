<?php
// Import the necessary classes
use Aura\Session\SessionFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Philo\Blade\Blade;
use RandomLib\Factory as PasswordFactory;
//database
$capsule = new Capsule;
$capsule->addConnection([
	'driver' => 'mysql',
	'host' => 'localhost',
	'database' => 'ovalinfo',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//manage session
$session_factory = new SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$segment = $session->getSegment('oval/signup');

//manage password generation
$factory = new PasswordFactory;
$generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
$pasword_characters = 'abcdefghijklmnopqrstuvwxyz';

//hashing IDs
$hashids = new Hashids\Hashids('REyUxDUiTEjlSqUBCRMXidLbuCLITJMoaehUoHmKrrZfeiXvaicKHBuUJjngTYzq', 10, 'abcdefghij1234567890');

//front-end view
$views = __DIR__ . '../../views';
$cache = __DIR__ . '../../cache';
$blade = new Blade($views, $cache);

$err = array();
$msg = array();
