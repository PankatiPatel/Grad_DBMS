<?php


include "dbconfig.php";
date_default_timezone_set('America/New_York');
 
if(!isset($_COOKIE["customer_id"]))
    header("location: ../index.html"); 





    $sql = "SELECT c.customer_id, 
                   c.login_id, 
                   c.password, 
                   c.first_name, 
                   c.last_name, 
                   c.TEL,
                   c.address,
                   c.city,
                   c.zipcode,
                   s.State,    
                   s.Code
            FROM 2022F_patpanka.CUSTOMER c,2022F_patpanka.STATES s  WHERE s.Code = c.State AND customer_id = " .$_COOKIE['customer_id'];
    
    $result = mysqli_query($conn,$sql); 
    $numRows = mysqli_num_rows($result);

    $state = "SELECT * FROM 2022F_patpanka.STATES";
    $result2 = mysqli_query($conn,$state);
    $arr = mysqli_fetch_array($result2);

if($result)
    {
        if($numRows > 0)
        {
            echo "The following customers are in the database";
            echo "<form action ='customer_update_table.php' method = 'post'>";
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
                $state = $row["State"];
                $stateCode = $row["Code"]; 
    
               
                         echo "<TR>
                                <TD bgcolor = yellow > $id </TD>
                                <TD bgcolor = yellow > $login </TD>
                                <TD> <input type = 'text' name = 'password' value = '$password'> </TD> 
                                <TD> <input type = 'text' name = 'lName' value = '$lName' ></TD>
                                <TD> <input type = 'text' name = 'fName' value = '$fName' ></TD>
                                <TD> <input type = 'text' name = 'tel' value = '$tel' pattern='[0-9]{3}[0-9]{3}[0-9]{4}'></TD>
                                <TD> <input type = 'text' name = 'address' value = '$address'></TD>
                                <TD> <input type = 'text' name = 'city' value = '$city'></TD>
                                <TD> <input type = 'text' name = 'zipcode' value = '$zipcode' pattern= '[0-9]{5}'</TD>
                                <TD> <select name = 'state' >";
                                    
                                         while ($row2 = mysqli_fetch_array($result2))
                                         {
                                                if($state == $row2['State'])
                                                     echo "<option selected value='" . $row2['Code'] ."'>" . $row2['State'] ."</option>";
                                                else    
                                                    echo "<option value='" . $row2['Code'] ."'>" . $row2['State'] ."</option>";
                                         }

                                
                        echo "</select>  </TD>
            
                        </TR> ";
    
    
            }
            echo "</TABLE>";
            echo "<input type='submit' value='Update Information'>
                  </form>";

            echo "<br> <dr> <a href = 'customer_check_p2.php'> Customer home page</a>";
            echo "<br> <dr> <a href = '../index.html'>Project home page</a>";
        }
        else 
            echo 'There are no records'; 
    }
    else 
        echo "there is something wrong"; 

?>