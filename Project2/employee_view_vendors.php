
<HTML>
<title>View all vendors</title>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      #map-canvas {
        height: 600px;
        margin: 0px;
        padding: 0px
      }
    </style>


<body>

<div style="margin:auto;  width: 720px; ">

<?php

include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');

$empId = $_COOKIE["emp_mang_id"]; 

if(!isset($_COOKIE["emp_mang_id"]))
    header("location: employee_login.php");

echo "<a href='employee_logout.php'> Employee logout</a><br>";

$sql = "SELECT vendor_id, name, address, city, state, zipcode, CONCAT(latitude, longitude) AS GPS FROM CPS5740.VENDOR "; 

$result = mysqli_query($conn, $sql); 
$rows = mysqli_num_rows($result);

$array[] = array();
if($result)
{
    if($rows >0)
    {
        echo "<b style ='text-align: right;'>The following vendors are in the database</b>";
        echo "<form action = 'employee_product_update.php' method = 'post' >";
        echo  "<TABLE border=1>
                    <TR>
                        <TH> ID </TH>
                        <TH> Name </TH>
                        <TH> Address </TH>
                        <TH> City </TH>
                        <TH> State </TH>
                        <TH> Zipcode </TH>
                        <TH> Location(Latitude,Longitude) </TH>
                    </TR>";
                        while($row = mysqli_fetch_assoc($result))
                        {
                                $vendor_id = $row['vendor_id']; 
                                $name = $row['name'];
                                $address = $row['address'];
                                $city = $row['city'];
                                $state = $row['state'];
                                $zip = $row['zipcode'];
                                $location = $row['GPS'];
                                $array[] = $row;

                                echo "<TR>
                                        <TD> $vendor_id </TD>
                                        <TD> $name </TD>
                                        <TD> $address </TD> 
                                        <TD> $city </TD>
                                        <TD> $state </TD>
                                        <TD> $zip </TD>
                                        <TD> $location </TD>
                                     </TR> ";


                        }

        echo "</table>";
        
       

    }
    else 
        echo "There are no records";


}
else 
    echo "There is something wrong";




?>

<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="https://maps.google.com/maps/api/js?sensor=false" 
        type="text/javascript"></script>
</head>
<script type="text/javascript" src="map.js"></script>
   
</head>
<br>
<div id="map-canvas" style="height: 400px; width: 720px;"></div>
</div>
</body>
</HTML>







    