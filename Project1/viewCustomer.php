<?php
date_default_timezone_set('America/New_York');

include "dbconfig.php";



$sql = "SELECT * FROM 2022F_patpanka.CUSTOMER ";

$result = mysqli_query($conn,$sql); 
$numRows = mysqli_num_rows($result);
if(isset ($_COOKIE["emp_mang_id"]))
{
if($result)
{
    if($numRows > 0)
    {
        echo "The following customers are in the database";
        echo  "<TABLE border=1>
        <TR>
            <TH>ID</TH>
            <TH>Login </TH>
            <TH>Password </TH>
            <TH>Last Name</TH>
            <TH>First Name </TH>
            <TH>TEL</TH>
            <TH>Address </TH>
            <TH>City </TH>
            <TH>Zipcode </TH>
            <TH>State </TH>
        </TR>";

        while($row = mysqli_fetch_array($result))
        {

            $id = $row["customer_id"];
            $login = $row["login_id"];
            $password = $row["password"]; 
            $fName = $row["first_name"];
            $lName = $row["last_name"];
            $tel = $row["TEL"];
            $address = $row["address"];
            $city = $row["city"]; 
            $zipcode = $row["zipcode"];
            $state = $row["state"]; 

            echo "<TR>
                <TD> $id </TD>
                <TD> $login </TD>
                <TD> $password </TD> 
                <TD> $lName </TD>
                <TD> $fName</TD>
                <TD> $tel</TD>
                <TD> $address</TD>
                <TD> $city</TD>
                <TD> $zipcode</TD>
                <TD> $state</TD>
             </TR> ";


        }
        echo "</TABLE>";
    }
    else 
        echo 'There are no records'; 
}
else 
    echo "there is something wrong"; 
}
else 
    echo "Please login as an employee/manager first";
?>