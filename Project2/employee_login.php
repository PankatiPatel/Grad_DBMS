

<?php

include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');

$empId = $_COOKIE["emp_mang_id"]; 

if(!isset($_COOKIE["emp_mang_id"]))
    header("location: employee_login.php");

$sql = "SELECT * FROM CPS5740.EMPLOYEE2 WHERE employee_id = '$empId'"; 

$result = mysqli_query($conn,$sql); 
$numRows = mysqli_num_rows($result); 
$paswordRow = mysqli_fetch_array($result);


if($result)
{
   if($numRows > 0)
   {    
     
  
                if($paswordRow["role"] =='M')
                $role = "Manager"; 
                else 
                $role = "Employee"; 


                
                checking_ip();  //ip address function
                echo "<br> Welcome ". $role. ": <b>" .$paswordRow['name']. "</br>";
                echo "<a href = 'employee_logout.php'> ". $role. "Logout</a><br>";
    

                echo "<br><br>";

                echo "<a href='employee_add_product.php'>Add Product</a> <br>";
                echo "<a href='employee_search_product.html'>Search and Update Product</a> <br>";
                echo "<a href='employee_view_vendors.php'>View Vendors</a> <br>";


                if($paswordRow['role'] == 'M')
                {
                   echo '<form name="input" action="manager_view_reports.php" method="post" >
                            View Reports - period:
                            <select name="report_period">
                                <option value="all">all</option>
                                <option value="past_week">past week (Sun-Sat)</option>
                                <option value="last_7days">last 7 days</option>
                                <option value="current_month">current month</option>
                                <option value="past_month">past month (1-31)</option>
                                <option value="last_30days">last 30 days</option>
                                <option value="this_year">this year (Jan to now)</option>
                                <option value="last_365days">last 365 days</option>
                                <option value="past_year">past year (Jan-Dec)</option>
                            </select>
                            , by:
                            <select name="report_type">
                                <option value="all">all sales</option>
                                <option value="products">products</option>
                                <option value="vendors">vendors</option>
                            </select>
                        <input type="submit" value="Submit">
                        </form>';
                }
                
    

   }
   else 
       echo "There is no account ";
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
