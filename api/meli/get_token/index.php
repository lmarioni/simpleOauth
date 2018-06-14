<?php

header('Content-type: application/json');
ini_set('display_errors', 0);

require '../meli.php';
require '../../functions.php';
global $app_id,$secret_key;

extract($_GET);



// Lee sellers
$access_token = getFieldValue("SELECT access_token FROM simpleoauth.users where the_token='".$token."';","access_token");


if($access_token!='0'){

	$expires_in = getFieldValue("SELECT expires_in FROM simpleoauth.users where the_token='".$token."';","expires_in");

	if($expires_in < time()) {

		$user_id = getFieldValue("SELECT user_id FROM simpleoauth.users where the_token='".$token."';","user_id");
		$refresh_token = getFieldValue("SELECT refresh_token FROM simpleoauth.users where the_token='".$token."';","refresh_token");
		$get_app_id = getFieldValue("SELECT app_id FROM simpleoauth.users where the_token='".$token."';","app_id");
		$get_secret_key = getFieldValue("SELECT secret_key FROM simpleoauth.users where the_token='".$token."';","secret_key");

		if($get_app_id!=''){$app_id=$get_app_id;};
		if($get_secret_key!=''){$secret_key=$get_secret_key;};

		try {

			$meli = new Meli($app_id, $secret_key,$access_token,$refresh_token);
			
			$refresh 		= 	$meli->refreshAccessToken();
			$access_token 	= 	$refresh['body']->access_token;
			$expires_in 	= 	time() + $refresh['body']->expires_in;
			$refresh_token 	= 	$refresh['body']->refresh_token;

			$query = "UPDATE simpleoauth.users SET access_token='$access_token', expires_in='$expires_in', refresh_token='$refresh_token' WHERE user_id='$user_id' AND app_id='$app_id' AND secret_key='$secret_key';";
			$q = updateQuery($query);

			echo "{\"access_token\":\"$access_token\",\"updated\":true}";
			die;
		} catch (Exception $e) {
		  	echo "{\"error\":\"$e->getMessage()\"}";
		  	die;
		}
	}

}


echo "{\"access_token\":\"$access_token\"}";
?>