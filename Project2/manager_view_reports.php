<?php
 include ("dbconfig.php"); 
 date_default_timezone_set('America/New_York');
 
 $empId = $_COOKIE["emp_mang_id"]; 
 
 if(!isset($_COOKIE["emp_mang_id"]))
     header("location: employee_login.php");

     
if(isset($_POST['report_period']))
   $report_period = $_POST['report_period'];


if(isset($_POST['report_type']))
    $report_type = $_POST['report_type'];


echo "report by: ". $report_type. " during period: ". $report_period;

if($report_period == 'past_week')
{
    $date_filter = " o.date >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+6 DAY) 
                     AND o.date <  DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)";
          
}


else if($report_period == 'last_7days')
{
    $date_filter = " o.date BETWEEN DATE_ADD(NOW(), INTERVAL -7 DAY) AND NOW() ";
}

else if($report_period == "current_month")
{
    $date_filter = " MONTH(o.date) = MONTH(NOW())";
}

else if($report_period == "past_month")
{
    $date_filter = " MONTH(o.date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
                    AND YEAR(o.date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) ";
}

else if($report_period == "last_30days")
{
    $date_filter = " o.date BETWEEN DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW()";

}
else if($report_period == "this_year")
{
    $date_filter = " YEAR(o.date) = YEAR(NOW())";
}

else if($report_period == "last_365days")
{
    $date_filter = "  o.date BETWEEN DATE_ADD(NOW(), INTERVAL -365 DAY) AND NOW()";
          
}

else // past year 
{
    $date_filter = "  YEAR(o.date) = YEAR(CURRENT_DATE - INTERVAL 1 YEAR)";
               
}


if($report_type == "all")
{
    if($report_period == 'all')
    {
        $sql = "SELECT  p.name AS pname, 
                        v.name AS vname, 
                        p.cost, 
                        p.quantity AS currentQuantity, 
                        po.quantity AS soldQuantity,
                        p.sell_price,
                        (po.quantity * p.sell_price) AS totalSales,
                        (po.quantity * p.sell_price) - (po.quantity * p.cost) AS profit,
                        CONCAT(c.first_name, ' ', c.last_name) AS name, 
                        po.order_id,
                        o.date AS DATE
                FROM 2022F_patpanka.PRODUCT_ORDER2 po, 
                    CPS5740.VENDOR v, 
                    2022F_patpanka.CUSTOMER c,
                    2022F_patpanka.ORDER2 o,
                    2022F_patpanka.PRODUCT2 p
                WHERE p.id = po.product_id 
                AND   p.vendor_id = v.vendor_id
                AND   o.customer_id = c.customer_id
                AND   o.id = po.order_id
                GROUP BY c.customer_id, po.product_id, po.order_id ";
    }
    else 
    {
        $sql = "SELECT  p.name AS pname, 
                        v.name AS vname, 
                        p.cost, 
                        p.quantity AS currentQuantity, 
                        po.quantity AS soldQuantity,
                        p.sell_price,
                        (po.quantity * p.sell_price) AS totalSales,
                        (po.quantity * p.sell_price) - (po.quantity * p.cost) AS profit,
                        CONCAT(c.first_name, ' ', c.last_name) AS name, 
                        po.order_id,
                        o.date AS DATE
                FROM 2022F_patpanka.PRODUCT_ORDER2 po, 
                    CPS5740.VENDOR v, 
                    2022F_patpanka.CUSTOMER c,
                    2022F_patpanka.ORDER2 o,
                    2022F_patpanka.PRODUCT2 p
                WHERE p.id = po.product_id 
                AND   p.vendor_id = v.vendor_id
                AND   o.customer_id = c.customer_id
                AND   o.id = po.order_id
                AND   $date_filter
                GROUP BY c.customer_id, po.product_id, po.order_id ";
    }

    $i = 1;
    $totalSales = 0;
    $totalProfit = 0;
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);

    if($result)
    {
        if($rows > 0)
        {
            echo  "<TABLE border=1>
                        <TR>
                            <TH>#</TH>
                            <TH> Product Name </TH>
                            <TH> Vendor Name </TH>
                            <TH> Unit Cost </TH>
                            <TH> Current Quantity </TH>
                            <TH> Sold Quantity </TH>
                            <TH> Sold Unit Price </TH>
                            <TH> Total Sales </TH>
                            <TH> Profit </TH>
                            <TH> Customer Name </TH>
                            <TH> Order Date </TH>
                        </TR>";
                
            while($row = mysqli_fetch_array($result))
            {
                $prod_name = $row["pname"];
                $vendor_name = $row["vname"];
                $cost = $row["cost"];
                $curr_qty = $row["currentQuantity"]; 
                $sold_qty = $row["soldQuantity"];
                $sell_price = $row["sell_price"];
                $total_sale = $row["totalSales"];
                $profit = $row["profit"];
                $name = $row["name"];
                $order_id = $row["order_id"];
                $date = $row["DATE"];
                $totalSales += $total_sale;
                $totalProfit += $profit;

                 echo   "<TR>
                            <TD> $i </TD>
                            <TD> $prod_name </TD>
                            <TD> $vendor_name </TD> 
                            <TD> $cost </TD>
                            <TD> $curr_qty </TD>
                            <TD> $sold_qty </TD>
                            <TD> $sell_price </TD>
                            <TD> $total_sale </TD>
                            <TD> $profit </TD>
                            <TD> $name </TD>
                            <TD>  $date  </TD>
                        </TR> ";

                $i++;
            }
 
            echo "<TR>
                    <TD> Total </TD>
                    <TD colspan = '6'>  </TD>
                    <TD> $totalSales </TD>
                    <TD> $totalProfit</TD>
                 </TR>";
            echo "</TABLE>";
                    
        }
        else 
            echo "<br> There are no records";
    }
    else 
        echo "<br> error";
}


/////////////////////////////////////////////////////////

if($report_type == 'products')
{

    if($report_period == 'all')
    {
        $sql = "SELECT p.name AS pname,  
                       v.name AS vname,
                       p.cost, 
                       p.quantity currentQuantity,
                       sum(po.quantity) soldQuantity, 
                       p.sell_price, 
                       ((sum(po.quantity)) * p.sell_price) totalSales,
                       ((sum(po.quantity))*(p.sell_price-p.cost)) profit
                FROM 2022F_patpanka.PRODUCT_ORDER2 po
                RIGHT JOIN (2022F_patpanka.PRODUCT2 p
                JOIN CPS5740.VENDOR v  ON p.vendor_id = v.vendor_id )   
                ON p.id = po.product_id 
                GROUP BY p.name";
    }
    else 
    {
        $sql = "SELECT p.name AS pname,
                        v.name AS vname,
                        p.cost,
                        p. quantity AS currentQuantity, 
                        COUNT(po.quantity) AS soldQuantity, 
                        p.sell_price, 
                        (p.sell_price * COUNT(po.quantity)) AS totalSales,
                        ((p.sell_price * COUNT(po.quantity)) - p.cost) AS profit
                        
                FROM 2022F_patpanka.PRODUCT2 p

                JOIN CPS5740.VENDOR v 
                ON p.vendor_id = v.vendor_id
                
                LEFT JOIN 2022F_patpanka.PRODUCT_ORDER2 po 
                ON p.id = po.product_id

                JOIN 2022F_patpanka.ORDER2 o 
                ON o.id = po.order_id
                
                WHERE p.id IN (SELECT id FROM 2022F_patpanka.PRODUCT2 )
                AND $date_filter
                
                GROUP BY po.product_id"; 

                
    }

   
    $i = 1;
    $totalSales = 0;
    $totalProfit = 0;
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);

    if($result)
    {
        if($rows > 0)
        {
            echo  "<TABLE border=1>
                        <TR>
                            <TH>#</TH>
                            <TH> Product Name </TH>
                            <TH> Vendor Name </TH>
                            <TH> Unit Cost </TH>
                            <TH> Current Quantity </TH>
                            <TH> Sold Quantity </TH>
                            <TH> Sold Unit Price </TH>
                            <TH> Total Sales </TH>
                            <TH> Profit </TH>
                        </TR>";
                
            while($row = mysqli_fetch_array($result))
            {
                $prod_name = $row["pname"];
                $vendor_name = $row["vname"];
                $cost = $row["cost"];
                $curr_qty = $row["currentQuantity"]; 
                $sold_qty = $row["soldQuantity"];
                $sell_price = $row["sell_price"];
                $total_sale = $row["totalSales"];
                $profit = $row["profit"];
                $totalSales += $total_sale;
                $totalProfit += $profit;

                 echo   "<TR>
                            <TD> $i </TD>
                            <TD> $prod_name </TD>
                            <TD> $vendor_name </TD> 
                            <TD> $cost </TD>
                            <TD> $curr_qty </TD>
                            <TD> $sold_qty </TD>
                            <TD> $sell_price </TD>
                            <TD> $total_sale </TD>
                            <TD> $profit </TD>
                        </TR> ";

                $i++;
            }
 
            echo "<TR>
                    <TD> Total </TD>
                    <TD colspan = '6'>  </TD>
                    <TD> $totalSales </TD>
                    <TD> $totalProfit</TD>
                 </TR>";
            echo "</TABLE>";
                    
        }
        else 
            echo "<br> There are no records";
    }
    else 
        echo "<br> error";

}

if($report_type == 'vendors')
{

    if($report_period == 'all')
    {
        $sql = " SELECT s.name,
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
                    FROM 2022F_patpanka.PRODUCT2 p
                        RIGHT JOIN  CPS5740.VENDOR v 
                        ON  v.vendor_id = p.vendor_id
                        LEFT JOIN  2022F_patpanka.PRODUCT_ORDER2 po
                        ON p.id = po.product_id
                        
                        LEFT JOIN 2022F_patpanka.ORDER2 o 
                        ON o.id = po.order_id
                    
                    GROUP BY v.vendor_id

                )f,
                (
                    SELECT v.name,
                            v.vendor_id,
                            sum(p.quantity) AS in_stock
                    FROM 2022F_patpanka.PRODUCT2 p 
                        RIGHT JOIN CPS5740.VENDOR v
                        ON p.vendor_id = v.vendor_id
                    GROUP BY v.vendor_id
                
                )  s
                WHERE f.vendor_id = s.vendor_id";
    }
    else 
    {
        $sql = " SELECT s.name,
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
                    FROM 2022F_patpanka.PRODUCT2 p
                        RIGHT JOIN  CPS5740.VENDOR v 
                        ON  v.vendor_id = p.vendor_id
                        LEFT JOIN  2022F_patpanka.PRODUCT_ORDER2 po
                        ON p.id = po.product_id
                        
                        LEFT JOIN 2022F_patpanka.ORDER2 o 
                        ON o.id = po.order_id
                        
                        where $date_filter
                    GROUP BY v.vendor_id

                )f,
                (
                    SELECT v.name,
                            v.vendor_id,
                            sum(p.quantity) AS in_stock
                    FROM 2022F_patpanka.PRODUCT2 p 
                        RIGHT JOIN CPS5740.VENDOR v
                        ON p.vendor_id = v.vendor_id
                    GROUP BY v.vendor_id

                )  s
                WHERE f.vendor_id = s.vendor_id";
    }


    $i = 1;
    $totalSales = 0;
    $totalProfit = 0;
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);

    if($result)
    {
        if($rows > 0)
        {
            echo  "<TABLE border=1>
                        <TR>
                            <TH>#</TH>
                            <TH> Vendor Name </TH>
                            <TH> Quantity in Stock </TH>
                            <TH> Sold Quantity </TH>
                            <TH> Total Sale </TH>
                            <TH> Total Cost </TH>
                            <TH> Profit </TH>
                        </TR>";
                
            while($row = mysqli_fetch_array($result))
            {

                $vendor_name = $row["name"];
                $in_stock = $row["in_stock"];
                $sold_qty = $row["sold_quantity"]; 
                $total_sale = $row["total_sale"];
                $total_cost = $row["total_cost"];
                $profit = $row["profit"];
                $totalSales += $total_sale;
                $totalProfit += $profit;

                 echo   "<TR>
                            <TD> $i </TD>
                            <TD> $vendor_name </TD>
                            <TD> $in_stock </TD> 
                            <TD> $sold_qty </TD>
                            <TD> $total_sale </TD>
                            <TD>  $total_cost </TD>
                            <TD> $profit </TD>
                        </TR> ";

                $i++;
            }
 
            echo "<TR>
                    <TD> Total </TD>
                    <TD colspan = '4'>  </TD>
                    <TD> $totalSales </TD>
                    <TD> $totalProfit</TD>
                 </TR>";
            echo "</TABLE>";
                    
        }
        else 
            echo "<br> There are no records";
    }
    else 
        echo "<br> error";

}
?>