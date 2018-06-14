<?php 

// /api/meli/login/
session_start('meliexpress');
extract($_POST);

$_SESSION['app_id']=$app_id;
$_SESSION['secret_key']=$secret_key;

header('location:/api/meli/login/');
?>