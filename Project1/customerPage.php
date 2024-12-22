<?php

include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');
 



$sql = "SELECT * FROM 2022F_patpanka.CUSTOMER WHERE customer_id = " .$_COOKIE["customer_id"]; 

$result = mysqli_query($conn,$sql); 
$numRows = mysqli_num_rows($result); 
$paswordRow = mysqli_fetch_array($result);


if(isset($_COOKIE["customer_id"]))
{
if($result)
{
    if($numRows > 0)
    {
       
            
        echo "<br> Welcome customer <b>".$paswordRow['first_name']. " ". $paswordRow["last_name"]. "</b> </br>";
        echo "". $paswordRow["address"]. ", ". $paswordRow["city"]. ", ". $paswordRow["state"]. " ". $paswordRow["zipcode"];
        checking_ip();//user ip addess function

        echo "<br> <a href = 'customerLogout.php'>  Customer Logout</a>";
        echo "<br> <a href = 'customerUpdate.php'>  Update my Data</a>";

        echo "<br> <dr> <a href = './index.html'> Project Home Page</a>";    
    }
    else 
        echo "There are no records"; 

}
else    
    echo "There is something wrong";
}
else 
    header("location : index.html");
function checking_ip ()
 {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                    { $ip = $_SERVER['HTTP_CLIENT_IP']; }
                    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                    { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
                    else { $ip = $_SERVER['REMOTE_ADDR']; }
                    
                    echo "<br>Your IP: $ip\n";
                     $host = gethostbyaddr($ip);
                     $IPv4= explode(".",$ip);
                     if($IPv4[0] == "10" || ($IPv4[0] == "131" && $IPv4[1] == "125"))
                         echo ("<br> You are on Kean domain");
                     else 
                         echo ("<br> You are NOT on Kean domain");
 }

?>