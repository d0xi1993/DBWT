<?php
$servername="localhost";
$user="root";
$pwd="root";
$db="db_werbeseite";

$con= new mysqli($servername, $user,$pwd,$db);

if($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}

?>