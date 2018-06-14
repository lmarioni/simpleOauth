<?php

header('Content-type: application/json');
ini_set('display_errors', 0);
session_start('meliexpress');

require '../meli.php';
require '../../functions.php';
global $app_id, $secret_key;


$_SESSION['MELI_the_token'] = "";

if($_SESSION['app_id']!=""){$app_id=$_SESSION['app_id'];}
if($_SESSION['secret_key']!=""){$secret_key=$_SESSION['secret_key'];}



$meli = new Meli($app_id,$secret_key, 
			$_SESSION['MELI_seller_access_token'], $_SESSION['MELI_seller_refresh_token']);



if($_GET['code'] || $_SESSION['MELI_seller_access_token']) {

	// If code exist and session is empty
	if($_GET['code'] && !($_SESSION['MELI_seller_access_token'])) {
		// If the code was in get parameter we authorize
		
		if($_SERVER['SERVER_NAME']=='127.0.0.1'){
			$user = $meli->authorize($_GET['code'], 'https://simpleoauth.com/api/meli/login/');
		}else{
			$user = $meli->authorize($_GET['code'], 'https://simpleoauth.com/api/meli/login/');
		}
		// echo "{\"user\":0}";
		// echo json_encode($user);

		// Now we create the sessions with the authenticated user
		$_SESSION['MELI_seller_access_token'] = $user['body']->access_token;
		$_SESSION['MELI_seller_expires_in'] = time() + $user['body']->expires_in;
		$_SESSION['MELI_seller_refresh_token'] = $user['body']->refresh_token;
	} else {
		// We can check if the access token in invalid checking the time
		if($_SESSION['MELI_seller_expires_in'] < time()) {
			try {
				// Make the refresh proccess
				$refresh = $meli->refreshAccessToken();

				// echo "{\"refresh\":0},";
				// echo json_encode($refresh);
				
				// Now we create the sessions with the new parameters
				$_SESSION['MELI_seller_access_token'] = $refresh['body']->access_token;
				$_SESSION['MELI_seller_expires_in'] = time() + $refresh['body']->expires_in;
				$_SESSION['MELI_seller_refresh_token'] = $refresh['body']->refresh_token;
			} catch (Exception $e) {
			  	echo "Exception: ",  $e->getMessage(), "\n";
			  	
			}
		}
	}



	// Read users/me of this user

	$authParams = array('access_token'=>$_SESSION['MELI_seller_access_token']);
	$res = $meli->get('/users/me', $authParams);
	// echo json_encode($res);
	// die;

	if($res['body']->status == 403){
			echo "Error 403. Ha ocurrido un problema con el servicio de OAuth de Mercado Libre. Vuelve a intentarlo en unos minutos";
			die;
	};

	$email 					= $res['body']->email;
	$identification_number 	= $res['body']->identification->number;
	$identification_type 	= $res['body']->identification->type;
	$nickname 				= $res['body']->nickname;
	$user_id 				= $res['body']->id;
	$site_id				= $res['body']->site_id;
	$points					= $res['body']->points;
	$access_token			= $_SESSION['MELI_seller_access_token'];
	$expires_in 			= $_SESSION['MELI_seller_expires_in'];
	$refresh_token 			= $_SESSION['MELI_seller_refresh_token'];
	$json					= json_encode($res);

	$app_info = $meli->get("/applications/$app_id", $authParams);
	$app_name = $app_info['body']->name;


	// Lee si existe el registro
	$check_user_id = getFieldValue("SELECT user_id FROM simpleoauth.users WHERE user_id='$user_id' AND app_id='$app_id' AND secret_key='$secret_key'","user_id");
	
	if($check_user_id){ 
		// Si existe lo actualiza
		$query = "UPDATE simpleoauth.users SET user_id='$user_id',nickname='$nickname',email='$email',identification_number='$identification_number',identification_type='$identification_type',user_json='$json', access_token='$access_token', expires_in='$expires_in', refresh_token='$refresh_token',site_id='$site_id',points=$points WHERE user_id='$user_id' AND app_id='$app_id' AND secret_key='secret_key';";
		$q = updateQuery($query);

		$the_token = getFieldValue("SELECT the_token FROM simpleoauth.users WHERE user_id='$user_id' AND app_id='$app_id' AND secret_key='$secret_key';","the_token");
		
	}else{

		// Si no existe lo crea

		// genera the_token:
		$the_token = md5(uniqid(rand(), true))."-".md5(uniqid($email, true))."-".md5(uniqid(rand(), true));

		$query = "INSERT INTO simpleoauth.users (the_token,user_id,nickname,email,identification_number,identification_type,user_json, access_token, expires_in, refresh_token,site_id,points, app_id,secret_key) VALUES ('$the_token','$user_id','$nickname','$email','$identification_number','$identification_type','$json','$access_token','$expires_in','$refresh_token','$site_id',$points,'$app_id','$secret_key')";
		$q = insertQuery($query);
		
	}

	
	
	$_SESSION['MELI_nickname']	= $nickname;
	$_SESSION['MELI_the_token']	= $the_token;
	$_SESSION['MELI_app_name']	= $app_name;
	header('location:https://simpleoauth.com/meli/done/');
	
} else {

	$_SESSION['MELI_the_token'] = "";



	header('location:'.$meli->getAuthUrl('https://simpleoauth.com/api/meli/login/', Meli::$AUTH_URL['MLC']));
}
