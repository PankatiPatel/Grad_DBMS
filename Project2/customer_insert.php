<?php

date_default_timezone_set('America/New_York');

include("dbconfig.php");


if(isset($_POST["login"]))
	$login = $_POST["login"];

if(isset($_POST["passwd1"]))
	$password1 = $_POST["passwd1"];

if(isset($_POST["passwd2"]))
	$password2 = $_POST["passwd2"];


if(isset($_POST["first_name"]))
	$fName = $_POST["first_name"];

if(isset($_POST["last_name"]))
	$lName = $_POST["last_name"];

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


$sql = "SELECT login_id FROM 2022F_patpanka.CUSTOMER WHERE login_id = '$login'";

$result = mysqli_query($conn, $sql); 
$numRows = mysqli_num_rows($result); 

if($result)
{
    if($numRows > 0 )
        echo $login. " exists try another login ID"; 
    
    elseif(strcmp($password1,$password2) != 0 )
        echo "passwords do not match try again";
     else 
    {
        $insertSql = "INSERT INTO 2022F_patpanka.CUSTOMER (login_id, password, first_name, last_name,TEL, address, city, zipcode, state )
                                                    VALUES('$login', '$password1', '$fName', '$lName','$tel','$address', '$city','$zipcode','$state' )";

        $insertResult = mysqli_query($conn, $insertSql); 

        if($insertResult)
            echo "Sucessfully created account";
        else 
            echo " Could not create account";

    }
}
else 
    echo "There is something wrong"

 


?>