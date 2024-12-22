<?php

include ("dbconfig.php");


$sql = "SELECT p.name AS product_name,
               v.name AS vendor_name,
               p.cost,
               p. quantity, 
               SUM(po.quantity) AS sold_quantity, 
               p.sell_price, 
               (p.sell_price * SUM(po.quantity)) AS sale_total,
               ((p.sell_price * SUM(po.quantity)) - p.cost) AS profit
        FROM PRODUCT p

        JOIN VENDOR v 
        ON p.vendor_id = v.vendor_id

        LEFT JOIN PRODUCT_ORDER po 
        ON p.product_id = po.product_id

        WHERE p.product_id IN (SELECT product_id FROM PRODUCT)

        GROUP BY p.product_id";

$result = mysqli_query($conn, $sql);
$numRow = mysqli_num_rows($result);

$increment_count = 1; 

$cost_total = 0; 
$total_quantity = 0; 
$total_sold_quantity = 0; 
$total_sell_price =0; 
$total_sale = 0; 
$total_profit = 0; 



if($result)
{
    if($numRow > 0)
    {
        echo "<TABLE border=1>
            <TR>
                <TH>#</TH>
                <TH> Product Name </TH>
                <TH> Vendor Name </TH>
                <TH> Cost</TH>
                <TH> Current Quantity </TH>
                <TH> Sold Quantity </TH>
                <TH> Sell Price </TH>
                <TH> Total Sales </TH>
                <TH> Profit </TH>
            </TR>";
        
        while($row = mysqli_fetch_array($result))
        {
            $prodcut_name = $row["product_name"];
            $vendor_name = $row["vendor_name"]; 
            $cost = $row["cost"];
            $quantity = $row["quantity"];
            $sold_quantity = $row["sold_quantity"];
            $sell_price = $row["sell_price"];
            $sale_total = $row["sale_total"]; 
            $profit = $row["profit"];
            


            $cost_total += $cost; 
            $total_quantity += $quantity; 
            $total_sold_quantity += $sold_quantity; 
            $total_sell_price += $sell_price; 
            $total_sale += $sale_total;
            $total_profit += $profit;


            echo "<TR>
                    <TD> $increment_count </TD>
                    <TD> $prodcut_name </TD>
                    <TD> $vendor_name</TD>
                    <TD> $cost </TD>
                    <TD> $quantity </TD>
                    <TD> $sold_quantity </TD>
                    <TD> $sell_price </TD>
                    <TD> $sale_total </TD>
                    <TD> $profit </TD>
                </TR>";
            
            
            $increment_count++;
          
        }

        echo "<TR>
                <TD> Total </TD>
                <TD> </TD>
                <TD> </TD>
                <TD> $cost_total </TD>
                <TD> $total_quantity </TD>
                <TD> $total_sold_quantity </TD>
                <TD> $total_sell_price </TD>
                <TD> $total_sale </TD>
                <TD> $total_profit </TD>
            </TR>";
     
        
    }
    else
        echo "There are no records";
}
else 
    echo "There is something wrong";

?>