<?php


include "dbconfig.php";
date_default_timezone_set('America/New_York');
 
if(!isset($_COOKIE["customer_id"]))
    header("location: ../index.html"); 

echo "<br> <a href = 'customer_logout.php'>  Customer Logout</a>";

if(isset($_GET['search_items']))
    $search = $_GET['search_items'];
    
setcookie("search_keyword",$search , time() + 3600,"/");
            
if($search == '*')
{
        $sql = "SELECT p.id,
                       p.name AS productName, 
                       p.description, 
                       p.sell_price, 
                       p.quantity, 
                       v.name AS vendorName, 
                       v.vendor_id 
                FROM 2022F_patpanka.PRODUCT2 p, CPS5740.VENDOR v
                WHERE p.vendor_id = v.vendor_id 
                HAVING quantity > 0";
}
    
 else
{
        $sql = "SELECT p.id,
                       p.name AS productName, 
                       p.description,
                       p.sell_price, 
                       p.quantity, 
                       v.name AS vendorName, 
                       v.vendor_id 
                FROM 2022F_patpanka.PRODUCT2 p, CPS5740.VENDOR v
                WHERE p.vendor_id = v.vendor_id
                AND p.name IN (select p2.name from 2022F_patpanka.PRODUCT2 p2 where p2.name LIKE CONCAT('%', '$search', '%'))
                GROUP BY p.id
                HAVING quantity > 0
                
                UNION 

                SELECT p.id,
                       p.name AS productName, 
                       p.description,
                       p.sell_price, 
                       p.quantity, 
                       v.name AS vendorName, 
                       v.vendor_id 
                FROM 2022F_patpanka.PRODUCT2 p, CPS5740.VENDOR v
                WHERE p.vendor_id = v.vendor_id
                AND p.name IN (select p2.name from 2022F_patpanka.PRODUCT2 p2 where  p2.description LIKE CONCAT('%', '$search', '%'))
                GROUP BY p.id
                HAVING quantity > 0";
}
    

$result = mysqli_query($conn, $sql); 
$rows = mysqli_num_rows($result);

$i = 0;

if($result)
{
    if($rows > 0)
    {
        echo "<br>Product list for search: " . $search;
        echo "<form action = 'customer_order.php' method = 'post' >";
        echo  "<TABLE border=1>
        <TR>
            <TH> Product Name </TH>
            <TH> Description </TH>
            <TH> Sell Price </TH>
            <TH> Avalible Quantity </TH>
            <TH> Order Quantity </TH>
            <TH> Vendor Name </TH>
        </TR>";

        while($row = mysqli_fetch_array($result))
        {

            // select from vendor goes in loop so there is data in each dropdown or else it will only display output for first row
   

            $productID = $row["id"];
            $productName = $row["productName"]; 
            $description = $row["description"];
            $sellPrice = $row["sell_price"];
            $qty = $row["quantity"];
            $vendorName = $row["vendorName"];
            $vendorID = $row["vendor_id"];


                echo "<TR>
                            <TD> $productName </TD>
                            <TD> $description </TD> 
                            <TD> $sellPrice </TD>
                            <TD> $qty</TD>
                            <TD> <input type = 'number' name = 'buy_qty[$i]> ' max = '$qty' </TD>
                            <TD> $vendorName </TD>
                            <input type = 'hidden' value = '$productID' name = 'productID[$i]'>
                           
                        
                     </TR>";
             
            $i++;
        }

        echo "</table>";
        echo "<input type = 'submit' value = 'Place Order'>";
        echo "</form>";
        echo "<a href='customer_check_p2.php'> Customer Home Page</a><br>";
        echo "<a href='../index.html'> Project Home Page </a><br>";
      
    }
    else 
        echo "<br>There are no records for: ". $searchs;
}
else 
    echo "There is something wrong";




?>


