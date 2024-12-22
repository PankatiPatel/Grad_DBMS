<?php


include "dbconfig.php";
date_default_timezone_set('America/New_York');
 
if(!isset($_COOKIE["customer_id"]))
    header("location: ../index.html"); 
   
$customer_id = $_COOKIE["customer_id"];


echo "<br> <a href = 'customer_logout.php'>  Customer Logout</a>";


$sql = " SELECT distinct(po.order_id) FROM 2022F_patpanka.PRODUCT_ORDER2 po, 2022F_patpanka.ORDER2 o WHERE o.id = po.order_id AND o.customer_id = '$customer_id'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result);

$order_id_total = 0;
$grand_total = 0;

if($result)
{
    if($rows > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $array[] = $row['order_id'];
        }
        
        foreach($array as $key => $id)
        {

            $sql =  "SELECT po.order_id, p.name, po.quantity, p.sell_price, (po.quantity * p.sell_price) AS subtotal ,o.date FROM 2022F_patpanka.ORDER2 o, 2022F_patpanka.PRODUCT_ORDER2 po, 2022F_patpanka.PRODUCT2 p
                     WHERE po.order_id = o.id AND p.id = po.product_id AND o.customer_id = '$customer_id' AND po.order_id = '$array[$key]'";

            $result1 = mysqli_query($conn, $sql);
            $rows1 = mysqli_num_rows($result);
            $order_id_total = 0;

            if($result1)
            {
                if($rows1 > 0)
                {
                    echo  "<TABLE border=1>
                    <TR>
                        <TH> id </TH>
                        <TH> name </TH>
                        <TH> Quantity </TH>
                        <TH> sell </TH>
                        <TH> sub </TH>
                        <TH> date </TH>

                    </TR>";
                    while($row1 = mysqli_fetch_array($result1))
                    {
                        $order_id = $row1["order_id"];
                        $name = $row1['name'];
                        $qty = $row1['quantity'];
                        $sell_price = $row1['sell_price'];
                        $subtotal = $row1['subtotal'];
                        $date = $row1['date'];
                        $order_id_total += $subtotal;
                        $grand_total += $subtotal;
    
                       
                        echo "<TR>
                                <TD> $order_id </TD>
                                <TD> $name </TD>
                                <TD> $qty </TD>
                                <TD> $sell_price </TD>
                                <TD> $subtotal </TD>
                                <TD> $date </TD>
                            </TR>";

                    }
                    echo "<TR>
                            <TD> </TD>
                            <TD> Order Paid </TD>
                            <TD colspan = '3' style = 'text-align: right;'> $order_id_total </TD>
                        </TR>";
                    echo "</table> <br><br>";

                      
                }
               
                else
                    echo "<br> There is no order history";
            }
            else 
                echo "<br> there is something wrong";

        }
            
    }
    else 
        echo "<br> There is no order history";
}
else 
    echo "<br> There is an error";

    
    echo  "<TABLE border=1>
    <TR>
        <TH> Total Paid </TH>
        <TD> $grand_total </TD>
        
    </TR> </TABLE> <br>";

    echo "<a href='customer_check_p2.php'> Customer Home Page</a><br>";
    echo "<a href='../index.html'> Project Home Page </a><br>";



?>