<?php
// GENERIC FUNCTIONS TO BE INCLUDED

ini_set('display_errors', 0);
$rootPath = $_SERVER['DOCUMENT_ROOT'];

include_once 'vars.php';
global $dbServer, $dbUser, $dbPass, $dbName, $app_id, $secret_key;

////////////////////////////////////////////////////////////////////////////////
/*
FUNCTION: executeQuery
PARAMETERS: $query
DESCRIPTION:
   Makes a SQL query
RETURNS: JSON query result
EXAMPLE:

*/
function executeQuery($query,$cache=false){
	$cachedResultQuery =null;


	if($cache){
		$redis=new Redis();
		$redis->connect('127.0.0.1',6379);
		$qh = md5($query);
		$cachedResultQuery = $redis->get($qh);
		if($cachedResultQuery){
			$cached=true;
		}else{
			$cached=false;
		}
	}else{
		$cached=false;
	}

	global $dbServer, $dbUser, $dbPass, $dbName;

	if(!$cached){

		$con = mysql_connect($dbServer,$dbUser,$dbPass);

		if (!$con){die('express.mercadolibre.com > Database problem :(' . mysql_error());}

		mysql_select_db($dbName, $con);

		$mysql_result = mysql_query($query);

		$rows = array();

		while($r = mysql_fetch_assoc($mysql_result)) {
	   		 $rows[] = $r;
		}

		mysql_close($con);
		$res=json_encode($rows);

		if($cache){
			$redis->set($qh,$res);
		}

		return $res;
	}else{
		return $cachedResultQuery;
	}


}


////////////////////////////////////////////////////////////////////////////////
/*
FUNCTION: executeQuery
PARAMETERS: $query
DESCRIPTION:
   Makes a SQL query
RETURNS: JSON query result
EXAMPLE:

*/
function executeQueryArray($query){

	global $dbServer, $dbUser, $dbPass, $dbName;

	$con = mysql_connect($dbServer,$dbUser,$dbPass);

	if (!$con){die('express.mercadolibre.com > Database problem :(' . mysql_error());}

	mysql_select_db($dbName, $con);

	$mysql_result = mysql_query($query);

	$rows = array();

	while($r = mysql_fetch_assoc($mysql_result)) {
   		 $rows[] = $r;
	}

	mysql_close($con);
 	return $rows;
}


////////////////////////////////////////////////////////////////////////////////
/*
FUNCTION: executeQuery
PARAMETERS: $query
DESCRIPTION:
   Makes a SQL query
RETURNS: JSON query result
EXAMPLE:

*/
function updateQuery($query){

	global $dbServer, $dbUser, $dbPass, $dbName;


	$con = mysql_connect($dbServer,$dbUser,$dbPass);

	if (!$con){die('express.mercadolibre.com > Database problem :(' . mysql_error());}

	mysql_select_db($dbName, $con);

	$mysql_result = mysql_query($query);


	mysql_close($con);
 	return json_encode($mysql_result);
}


////////////////////////////////////////////////////////////////////////////////
/*
FUNCTION: executeQuery
PARAMETERS: $query
DESCRIPTION:
   Makes a SQL query
RETURNS: JSON query result
EXAMPLE:

*/
function deleteQuery($query){

	global $dbServer, $dbUser, $dbPass, $dbName;


	$con = mysql_connect($dbServer,$dbUser,$dbPass);

	if (!$con){die('express.mercadolibre.com > Database problem :(' . mysql_error());}

	mysql_select_db($dbName, $con);

	$mysql_result = mysql_query($query);
	$mysql_result = mysql_affected_rows();

	mysql_close($con);
 	return json_encode($mysql_result);
}


////////////////////////////////////////////////////////////////////////////////
/*
FUNCTION: fieldValue
PARAMETERS: $query, $field
DESCRIPTION:
   Makes a SQL query
RETURNS: returns the field value in text format
EXAMPLE:

*/
function getFieldValue($query,$field){

	global $dbServer, $dbUser, $dbPass, $dbName;
	$con = mysql_connect($dbServer,$dbUser,$dbPass);

	if (!$con){die('Database problem :(' . mysql_error());}
	$retu='0';
	mysql_select_db($dbName, $con);

	$mysql_result = mysql_query($query);

	$rs = array();
 	while($rs = mysql_fetch_assoc($mysql_result)) {
		$retu=$rs[$field];
  	}
	mysql_close($con);
 	return $retu;
}


////////////////////////////////////////////////////////////////////////////////
/*
FUNCTION: insertQuery
PARAMETERS: $query
DESCRIPTION:
   insert record in a table
RETURNS: JSON
EXAMPLE:

*/

function insertQuery($query){
	global $dbServer, $dbUser, $dbPass, $dbName;
	$con = mysql_connect($dbServer,$dbUser,$dbPass);

	$mysql_result="0";

	if (!$con){die('Database problem :(' . mysql_error());}

	mysql_select_db($dbName, $con);

	mysql_query($query);

	$mysql_result = mysql_insert_id();



	mysql_close($con);
	return json_encode($mysql_result);
}
////////////////////////////////////////////////////////////////////////////////

function right($value, $count){
    return substr($value, ($count*-1));
}

function left($string, $count){
    return substr($string, 0, $count);
}

function len($string){
	return strlen($string);
}

function instr($string,$charsearch){
	return strrpos($string, $charsearch);
}

////////////////////////////////////////////////////////////////////////////////


function sanitizeString($var) {

   	$var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return trim($var);
}

function replace_string($string){

	$string = utf8_decode($string);
	$tofind = utf8_decode('ÌÁÌÛÌ?Ì©Ì¬ÌäÌ»Ì?Ì*Ì?ÌÒÌ¦Ì¼Ì?Ì±ÌÔÌ¤');
	$replac = '‡ËŠŽƒ¾’—îšŸœ–„';

	return strtr($string, $tofind, $replac);
}


function getPageTitle($Url){
    $str = file_get_contents($Url);
    $title="";
    if(strlen($str)>0){
        preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
        $title=$title[1];
    }
    return $title;
}

function genRandomString($num) {
    $length = $num;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}




?>