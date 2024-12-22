<?php 

$host = "imc.kean.edu";
$username = "patpanka";
$password = "1129006";
$dbname = "CPS5740";


$conn = mysqli_connect($host, $username, $password, $dbname)
or die ("<br> Connection error". mysqli_connect_error());

?>