<?php

include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');

$emp_id = $_COOKIE["emp_mang_id"];
if(!isset($emp_id))
    header("location: ../index.html");



if(isset($_POST["product_name"]))
    $product_name  = $_POST["product_name"];

if(isset($_POST["description"]))
    $description  = $_POST["description"];

if(isset($_POST["cost"]))
    $cost = $_POST["cost"];

if(isset($_POST["sell_price"]))
    $sell_price = $_POST["sell_price"];



if(isset($_POST["quantity"]))
    $quantity = $_POST["quantity"];


if(isset($_POST["vendor_id"]))
    $vendor_id = $_POST["vendor_id"];



$sql = "SELECT id from 2022F_patpanka.PRODUCT2 where name = '$product_name'";
$result = mysqli_query($conn,$sql); 
$row = mysqli_num_rows($result); 

if($row > 0)
{
    echo "<a href='employee_logout.php'> Employee logout</a><br>";
    echo "Product ".$product_name." already exists <br><br>";

    echo "<a href='employee_add_product.php'> Add Product </a><br>";
    echo "<a href='../index.html'> Project Home Page  </a><br>";

}
else if($cost > $sell_price)
{   
    echo "<a href='employee_logout.php'> Employee logout</a><br>";
    echo "The cost price is greater then your sell price <br><br>";

    echo "<a href='employee_add_product.php'> Add Product </a><br>";
    echo "<a href='../index.html'> Project Home Page  </a><br>";
}
else 
{
   $insert = "INSERT INTO 2022F_patpanka.PRODUCT2 VALUES (NULL, '$description', '$product_name','$vendor_id', '$cost','$sell_price','$quantity','$emp_id')";

   if(mysqli_query($conn,$insert))
   {
        echo "<a href='employee_logout.php'> Employee logout</a><br>";
        echo 'Item '. $product_name. ' has been sucessfully added<br><br>';

        echo "<a href='employee_add_product.php'> Add Product </a><br>";
        echo "<a href='../index.html'> Project Home Page  </a><br>";

   }
   else 
        echo "Error in inserting product";

}
?>
