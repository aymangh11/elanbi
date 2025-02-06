<?php

$sname= "localhost";
$unmae= "ayman";
$password = "ayman";

$db_name = "elanbi";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}