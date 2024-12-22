<?php
include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');





if(isset($_POST["login"]) && isset($_POST["password"])){
    $login = $_POST["login"]);
    $pswd =  $_POST["password"]);
}


$sql = "SELECT * FROM CPS5740.EMPLOYEE WHERE login = '$login' "; 

$result = mysqli_query($conn,$sql); 
$numRows = mysqli_num_rows($result); 
$paswordRow = mysqli_fetch_array($result);


if($result)
{
   if($numRows > 0)
   {    
     if(strcmp($paswordRow["password"], $pswd) == 0)
     {
      
      
        setcookie("emp_mang_id",$paswordRow["employee_id"] , time() + (60 * 1000),"/");
  
                if($paswordRow["role"] =='M')
                $role = "Manager"; 
                else 
                $role = "Employee"; 


                
                checking_ip();  //ip address function
                echo "<br> Welcome ". $role. ": <b>" .$paswordRow['name']. "</br>";
                echo "<a href='viewCustomer.php'>View all customers</a> <br>";
                
                echo "<a href = 'empLogout.php'> ". $role. " Logout</a>";
        }
        else
            echo "Employee " .$paswordRow["name"]. " exists, but password does not match";

   }
   else 
        echo "Login ID ". $login. " does not exist in the database";
}
else 
    echo "There is something wrong";



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