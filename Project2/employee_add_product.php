<?php
include ("dbconfig.php"); 
date_default_timezone_set('America/New_York');


if(!isset($_COOKIE["emp_mang_id"]))
    header("location: ../index.html");


$vendor = "SELECT * FROM CPS5740.VENDOR";
$result = mysqli_query($conn,$vendor);



?>
<HTML>
        <a href='employee_logout.php'> Employee logout</a><br>
        <br>
        <font size=4><b>Add products</b></font>
        <form name="input" action="employee_insert_product.php" method="post" >
        <br> Product Name: <input type="text" name="product_name" required="required">
        <br> Description: <input type="text" name="description" required="required">
        <br> Cost: <input type="number" name="cost" min ="1" required="required">
        <br> Sell Price: <input type="number" name="sell_price" min ="1" required="required">
        <br> Quantity: <input type="number" name="quantity" min ="1" required="required">
        <br>Select vendor:
         <SELECT name='vendor_id' required="required">
         <option value=''></option>
            <?php
                while($row = mysqli_fetch_array($result))
                {
                        echo '<option value = "' .$row["vendor_id"]. '">'.$row["name"].'</option>';
                }
            ?>
     

        
        </SELECT>
        <br><input type='hidden' name='employee_id' value='1'>
        <br><input type='submit' value='Submit'>
        </form>
</HTML>





</HTML>