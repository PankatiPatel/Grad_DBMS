<?php

date_default_timezone_set('America/New_York');

include("dbconfig.php");

if(!isset($_COOKIE["customer_id"]))
    header("location: ./index.html"); 

if(isset($_POST["password"]))
	$password = $_POST["password"];


if(isset($_POST["fName"]))
	$fName = $_POST["fName"];

if(isset($_POST["lName"]))
	$lName = $_POST["lName"];

 if(isset($_POST["tel"]))
	$tel= $_POST["tel"];

if(isset($_POST["address"]))
	$address = $_POST["address"];

if(isset($_POST["city"]))
	$city = $_POST["city"];


if(isset($_POST["zipcode"]))
    $zipcode = $_POST["zipcode"];


if(isset($_POST["state"]))
    $state = $_POST["state"];

$sql = "UPDATE 2022F_patpanka.CUSTOMER 
       SET password = '$password', 
           first_name = '$fName',
           last_name = '$lName', 
           TEL = '$tel', 
           address = '$address', 
           city = '$city',
           zipcode = '$zipcode',
           state = '$state'
        WHERE customer_id = ". $_COOKIE["customer_id"];

 
if(mysqli_query($conn, $sql))
{
    echo "Sucessfully updated"; 
}
else 
    echo "Could not update";
?>