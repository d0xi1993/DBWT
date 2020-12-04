<?php

$servername="localhost";
$user="root";
$pwd="";
$db="db_emensawerbeseite";

$con= new mysqli($servername, $user,$pwd,$db);
/*
if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}
*/

if($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}

?>