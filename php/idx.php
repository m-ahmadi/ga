<?php

// https://github.com/google/google-api-php-client.git
require_once 'google-api-php-client/src/Google/autoload.php';



$apikey = 'AIzaSyBMeri_8Jsmo5qLW68Qa3rGhSQDjAFu5pE';
$clientid = '594204839102-7r5sejasdqalk1gkqpcs8fr9pr2t4pv5.apps.googleusercontent.com';
$clientsecret = 'vEtC9DVxlTJadB9AEyldtAIV';

$client = new Google_Client();

$client->setDeveloperKey($apikey);
$client->setClientId($clientid);
$client->setClientSecret($clientsecret);
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');
$client->setRedirectUri('http://localhost/oauth/idx.php');






if ( !isset($_GET['code']) ) {
	
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}




if ( isset($_GET['code'] ) ) {
	session_start();
	$result = $client->authenticate( $_GET['code'] );
	$access_token = $client->getAccessToken();
	$_SESSION['access_token'] = $access_token;
	$client->setAccessToken( $access_token );
	
	$j = json_decode( $access_token );
	
	
	$url = 'https://www.googleapis.com/userinfo/v2/me?access_token=' . $j->access_token;
	//header('Location: ' . $url);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	
	
	curl_exec($ch);
	echo curl_error($ch);
	
	curl_close($ch);
}



/*

https://www.googleapis.com/userinfo/v2/me
	?Authorization=Bearer ya29..0AI-G0E0lmW9Nlq467z8VDKgzfLMuifv_TuE69WceAQbg88PyUH3WKpxH0PGbePECA
	
	GET /userinfo/v2/me HTTP/1.1
	Host: www.googleapis.com
	Content-length: 0
	Authorization: Bearer ya29..0AI-G0E0lmW9Nlq467z8VDKgzfLMuifv_TuE69WceAQbg88PyUH3WKpxH0PGbePECA
	
	
	GET /userinfo/v2/me HTTP/1.1
	Host: www.googleapis.com
	Content-length: 0
	Authorization: Bearer ya29..0AI-G0E0lmW9Nlq467z8VDKgzfLMuifv_TuE69WceAQbg88PyUH3WKpxH0PGbePECA
	HTTP/1.1 200 OK
	Content-length: 388
	X-xss-protection: 1; mode=block
	Content-location: https://www.googleapis.com/userinfo/v2/me
	X-content-type-options: nosniff
	Expires: Mon, 01 Jan 1990 00:00:00 GMT
	Vary: Origin,X-Origin
	Server: GSE
	Pragma: no-cache
	Cache-control: no-cache, no-store, max-age=0, must-revalidate
	Date: Tue, 26 Apr 2016 10:13:49 GMT
	X-frame-options: SAMEORIGIN
	Content-type: application/json; charset=UTF-8

*/

?>


