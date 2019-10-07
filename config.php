<?php
	session_start();
	error_reporting(E_ALL);
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("6637330768-km669flflm0ct2nvptv6113bmujsui5p.apps.googleusercontent.com");
	$gClient->setClientSecret("LuC7NSDz1UESK-kSybU6w59_");
	$gClient->setApplicationName("InstaS");
	$gClient->setRedirectUri("http://localhost/googlel/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
