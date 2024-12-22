<?php

error_reporting(0);
include "dbconfig.php";
date_default_timezone_set('America/New_York');
 
if(!isset($_COOKIE["customer_id"]))
    header("location: ../index.html"); 

echo "<br> <a href = 'customer_logout.php'>  Customer Logout</a>";

$customer_id = $_COOKIE["customer_id"];

if(isset($_POST['buy_qty']))
    $qty = $_POST['buy_qty'];

if(isset($_POST['productID']))
{
    $prod_id = $_POST['productID'];
    $insert = "INSERT INTO 2022F_patpanka.ORDER2 VALUES (NULL, '$customer_id', NOW())";
    if(mysqli_query($conn,$insert))
         $order_id = mysqli_insert_id($conn);

}


$total = 0;



echo  "<TABLE border=1>
    <TR>
        <TH> Product Name </TH>
        <TH> Unit Price </TH>
        <TH> Quantity </TH>
        <TH> Sub Total </TH>
    </TR>";

foreach($qty as $key => $buy_qty)
{


    $sql = "SELECT name, sell_price, sum(sell_price * $qty[$key]) AS sum, quantity FROM 2022F_patpanka.PRODUCT2 WHERE id = $prod_id[$key]";

    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_array($result))
    {
        
            $productName = $row["name"]; 
            $sell_price= $row["sell_price"];
            $sub_total = $row["sum"];
            $avalible_qty = $row['quantity'];


    
                echo "<TR>
                        <TD> $productName </TD>
                        <TD> $sell_price </TD>
                        <TD> $qty[$key] </TD>
                        <TD> $sub_total </TD> 
                    </TR> ";
                $total += $sub_total;
    
        if($qty[$key] > $avalible_qty)
        {
            echo "connot complete"; 
            
        }
         
      
        $update = "UPDATE 2022F_patpanka.PRODUCT2 set quantity = quantity - $qty[$key] WHERE id = $prod_id[$key]";
        mysqli_query($conn,$update);

        $insert_product_order = "INSERT INTO 2022F_patpanka.PRODUCT_ORDER2 VALUES ($order_id, $prod_id[$key], $qty[$key])";
        mysqli_query($conn,$insert_product_order);

        
      
        
    }

}
           echo "<TR> 
                    <TD colspan = '3'> Total </TD>
                    <TD> $total </TD>
                 </TR>";

            echo "<br> <a href='customer_check_p2.php'> Customer Home Page</a><br>";
            echo "<a href='../index.html'> Project Home Page </a><br>";
    

?>

