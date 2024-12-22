<?php

include("dbconfig.php"); 
date_default_timezone_set('America/New_York');

if(!isset($_COOKIE["emp_mang_id"]))
    header("location: ../index.html");

echo "<a href='employee_logout.php'> Employee logout</a><br>";

if(isset($_POST["search_items"]))
    $search = $_POST["search_items"];



if($search == '*')
{
    $sql = "SELECT p.id, p.name AS productName, p.description, p.cost, p.sell_price, p.quantity, v.name AS vendorName, e.name AS employeeName, v.vendor_id 
            FROM 2022F_patpanka.PRODUCT2 p, CPS5740.VENDOR v, CPS5740.EMPLOYEE2 e 
            WHERE p.vendor_id = v.vendor_id AND p.employee_id = e.employee_id";
}

else
{
    $sql = "SELECT p.id, p.name AS productName, p.description, p.cost, p.sell_price, p.quantity, v.name AS vendorName, e.name AS employeeName, v.vendor_id 
            FROM 2022F_patpanka.PRODUCT2 p, CPS5740.VENDOR v, CPS5740.EMPLOYEE2 e 
            WHERE p.vendor_id = v.vendor_id AND p.employee_id = e.employee_id
            AND p.name IN (select p2.name from 2022F_patpanka.PRODUCT2 p2 where p2.name LIKE CONCAT('%', '$search', '%'))

            UNION 

            SELECT p.id, p.name AS productName, p.description, p.cost, p.sell_price, p.quantity, v.name AS vendorName, e.name AS employeeName, v.vendor_id 
            FROM 2022F_patpanka.PRODUCT2 p, CPS5740.VENDOR v, CPS5740.EMPLOYEE2 e 
            WHERE p.vendor_id = v.vendor_id AND p.employee_id = e.employee_id
            AND p.name IN (select p2.name from 2022F_patpanka.PRODUCT2 p2 where p2.description  LIKE CONCAT('%', '$search', '%'))";

}


$result = mysqli_query($conn, $sql); 
$rows = mysqli_num_rows($result);


$i = 0;

if($result)
{
    if($rows > 0)
    {
        echo "Product list for search: " . $search;
        echo "<form action = 'employee_product_update.php' method = 'post' >";
        echo  "<TABLE border=1>
        <TR>
            <TH> Product ID </TH>
            <TH> Product Name </TH>
            <TH> Description </TH>
            <TH> Cost </TH>
            <TH> Sell Price </TH>
            <TH> Avalible Quantity </TH>
            <TH> Vendor Name </TH>
            <TH> Last Updated By </TH>
        </TR>";

        while($row = mysqli_fetch_array($result))
        {

            // select from vendor goes in loop so there is data in each dropdown or else it will only display output for first row
            $vendors = "SELECT * FROM CPS5740.VENDOR ";
            $vendorResult = mysqli_query($conn, $vendors);

            $productID = $row["id"];
            $productName = $row["productName"]; 
            $description = $row["description"];
            $cost = $row["cost"];
            $sellPrice = $row["sell_price"];
            $qty = $row["quantity"];
            $vendorName = $row["vendorName"];
            $empName = $row["employeeName"]; 
            $vendorID = $row["vendor_id"];


                echo "<TR>
                            <TD> $productID </TD>
                            <TD> <input type = 'text' value = '$productName' name = 'product_name[$i]'> </TD>
                            <TD> <input type = 'text' value = '$description' name = 'description[$i]'> </TD> 
                            <TD> <input type = 'number' value = '$cost' name = 'cost[$i]' min = '1' ></TD>
                            <TD> <input type = 'number' value = '$sellPrice' name = 'sell_price[$i]' min ='1' > </TD>
                            <TD> <input type = 'number' value = '$qty' name = 'qty[$i]' min = '1'> </TD>";
                      echo "<TD> <select name = 'vendor_name[$i]'>
                                    <option value = '$vendorID'> $vendorName </option>";

                                    while ($row = mysqli_fetch_array($vendorResult))
                                    {
                                        if($vendorName == $row['name'])
                                            echo "<option selected value='" . $row['vendor_id'] ."'>" . $row['name'] ."</option>";
                                        else
                                            echo "<option value='" . $row['vendor_id'] ."'>" . $row['name'] ."</option>";
                                    }

                        echo     "</select> </TD> 
                            <TD> $empName </TD>
                            <input type = 'hidden' value = '$productID' name = 'productID[$i]'>
                        
                     </TR>";
             
            $i++;
        }

        echo "</table>";
        echo "<input type = 'submit' value = 'Update Product'>";
        echo "</form>";
        echo "<a href='employee_login.php'> Employee Home Page</a><br>";
        echo "<a href='../index.html'> Project Home Page </a><br>";
      
    }
    else 
        echo "There are no records";
}
else 
    echo "There is something wrong";



?>
