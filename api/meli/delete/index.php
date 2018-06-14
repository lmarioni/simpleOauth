<?php

ini_set('display_errors', 1);

require '../../functions.php';



// Delete unique token
$res = deleteQuery('DELETE FROM simpleoauth.users WHERE the_token="'.$_REQUEST['token'].'";');

header('location: /');


?>