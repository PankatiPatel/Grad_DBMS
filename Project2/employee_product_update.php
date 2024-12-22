<?php

include("dbconfig.php"); 
date_default_timezone_set('America/New_York');

if(!isset($_COOKIE["emp_mang_id"]))
    header("location: ../index.html");

$emp_id = $_COOKIE["emp_mang_id"];

echo "<a href='employee_logout.php'> Employee logout</a><br>";


if(isset($_POST["product_name"]))
    $prod_name = $_POST["product_name"];


if(isset($_POST["description"]))
    $desc = $_POST["description"]; 


 if(isset($_POST["cost"]))
    $cost = $_POST["cost"]; 


if(isset($_POST["sell_price"]))
    $sell_price = $_POST["sell_price"]; 

if(isset($_POST["qty"]))
    $qty = $_POST["qty"]; 



if(isset($_POST["vendor_name"]))
    $vendor_name = $_POST["vendor_name"]; 


if(isset($_POST["productID"]))
    $prod_id = $_POST["productID"]; 




foreach($prod_id as $key => $product_id)
{
    $sql = "SELECT * FROM 2022F_patpanka.PRODUCT2 WHERE id =". $prod_id[$key];

    $result = mysqli_query($conn, $sql); 
    $rows = mysqli_num_rows($result); 

    while($row = mysqli_fetch_array($result))
    {
            $productID = $row["id"];
            $description = $row["description"];
            $productName = $row["name"]; 
            $vendorID = $row["vendor_id"];
            $cost2 = $row["cost"];
            $sellPrice = $row["sell_price"];
            $qty2 = $row["quantity"];
            $empID = $row["employee_id"];


            if( ($cost[$key] < $sell_price[$key]))
            {
               

                if(($prod_name[$key] != $productName) OR ($desc[$key] != $description) OR ($cost[$key] != $cost2) OR ($sell_price[$key] != $sellPrice) OR ($qty[$key] != $qty2) OR ($vendor_name[$key] != $vendorID))
                {
                      $update = " UPDATE 2022F_patpanka.PRODUCT2 set name = '$prod_name[$key]', 
                                                                 description = '$desc[$key]',
                                                                cost = '$cost[$key]',
                                                                sell_price = '$sell_price[$key]',
                                                                quantity = '$qty[$key]',
                                                                vendor_id = '$vendor_name[$key]',
                                                                employee_id = '$emp_id' WHERE id = $prod_id[$key]";


                    if(mysqli_query($conn, $update))
                        echo "<br>Sucessfully Updated Product ID: ". $prod_id[$key]. '<br>';
                    else 
                        echo "There was an error trying to update";
                }
            }
            else 
                echo "<br>Cannot Update cost is more then sell price for product id: ". $prod_id[$key];
    


    }

    
    

}





?>
