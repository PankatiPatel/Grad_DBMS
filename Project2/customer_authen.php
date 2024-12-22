<?php

include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');

 if(isset($_POST["login"]) && isset($_POST["password"])){
        $login = mysqli_real_escape_string($conn,$_POST["login"]);
        $pswd = mysqli_real_escape_string($conn,$_POST["password"]);
    }


$sql = "SELECT * FROM 2022F_patpanka.CUSTOMER WHERE login_id = '$login' "; 

$result = mysqli_query($conn,$sql); 
$numRows = mysqli_num_rows($result); 
$paswordRow = mysqli_fetch_array($result);



if($result)
{
    if($numRows > 0)
    {
        if(strcmp($paswordRow["password"],$pswd) == 0)
        {
         
            
            setcookie("customer_id",$paswordRow["customer_id"] , time() + (3600),"/");
            
            header("location: customer_check_p2.php");
            

                    }
        else 
            echo "Authentication error please try again"; 
    }
    else 
        echo "Authentization error please try again"; 

}
else    
    echo "There is something wrong";



?>