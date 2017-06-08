<?php

error_reporting(E_ALL);
session_start();

//echo __DIR__; die();

require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__ . "/../config.ini", true);
$factory = new jrothert\Factory($config);

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		break;
	case "/login":
		$cnt = $factory->getLoginController();
		if($_SERVER["REQUEST_METHOD"] === "GET") {
			$cnt->showLogin();
		} else {
			$cnt->login($_POST);
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		echo "Not Found";
		
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$success = password_verify($password, $hash);
}

