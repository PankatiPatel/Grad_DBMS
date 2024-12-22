
<?php
include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');




if(isset($_POST["login"]) && isset($_POST["password"])){
    $login = $_POST["login"];
    $pswd =  $_POST["password"];
}



$pswd = hash("sha256", $pswd, false);

$sql = "SELECT * FROM CPS5740.EMPLOYEE2 WHERE login = '$login'"; 

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
            header('location: employee_login.php');
  
    
                
               
        }
        else
            echo "Employee " .$paswordRow["name"]. " exists, but password does not match";

   }
   else 
        echo "Login ID ". $login. " does not exist in the database";
}
else 
    echo "There is something wrong";

 
?>