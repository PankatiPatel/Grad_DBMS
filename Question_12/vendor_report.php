<?php

// insert commas and change table layout
include("dbconfig.php"); 

$sql = "SELECT s.name,
               s.in_stock, 
               f.sold_quantity,
                f.total_sale, 
                f.total_cost, 
                f.profit 
        FROM 
        (
	        SELECT  v.vendor_id,
                    sum(po.quantity)AS sold_quantity, 
                    sum(p.sell_price * po.quantity) AS total_sale,
                    sum(p.cost* po.quantity) AS total_cost, 
		            (sum(p.sell_price * po.quantity) - sum(p.cost* po.quantity)) AS profit
		    FROM PRODUCT p
	            RIGHT JOIN  VENDOR v 
	            ON  v.vendor_id = p.vendor_id
	            LEFT JOIN  PRODUCT_ORDER po
	            ON p.product_id = po.product_id
	        GROUP BY v.vendor_id
	
        )f,
        (
		    SELECT v.name,
                   v.vendor_id,
                   sum(p.quantity) AS in_stock
			FROM PRODUCT p 
			    RIGHT JOIN VENDOR v
			    ON p.vendor_id = v.vendor_id
			GROUP BY v.vendor_id
		
        )  s
        WHERE f.vendor_id = s.vendor_id";

$result = mysqli_query($conn, $sql); 
$numRow = mysqli_num_rows($result); 





$increment_count = 1;
$total_stock =0; 
$total_cost = 0; 
$total_sold = 0; 
$total_sale = 0; 
$total_profit = 0; 

if($result)
{
   if($numRow > 0)
   {
        
      echo  "<TABLE border=1>
            <TR>
                <TH>#</TH>
                <TH> Vendor Name </TH>
                <TH> Quantity in Stock </TH>
                <TH> Total Cost</TH>
                <TH> Sold Quantity </TH>
                <TH> Total Sale </TH>
                <TH> Profit </TH>
            </TR>";

    
        
        while($row = mysqli_fetch_array($result))
        {
            $vendor_name = $row["name"];
            $stock_quantity = $row["in_stock"];
            $cost_total = $row["total_cost"];
            $sold_quantity = $row["sold_quantity"];
            $sale_total = $row["total_sale"]; 
            $profit = $row["profit"]; 


            echo "<TR>
                    <TD> $increment_count </TD>
                    <TD> $vendor_name </TD>
                    <TD> $stock_quantity </TD> 
                    <TD> $cost_total </TD>
                    <TD> $sold_quantity </TD>
                    <TD> $sale_total </TD>
                    <TD> $profit </TD>
                 </TR> ";
            $increment_count++;

            $total_stock += $stock_quantity;
            $total_cost += $cost_total;
            $total_sold += $sold_quantity;
            $total_sale += $sale_total;
            $total_profit += $profit;

        }

        echo "<TR>
                <TD>Total</TD>
                <TD> </TD>
                <TD> $total_stock </TD>
                <TD> $total_cost </TD>
                <TD> $total_sold </TD>
                <TD> $total_sale </TD>
                <TD> $total_profit </TD>
             </TR>";

        echo "</TABLE>";
   }
   else 
    echo "There are no records";
}
else 
    echo "There is an error";


?>



