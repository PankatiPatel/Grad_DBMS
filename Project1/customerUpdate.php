<?php

if(!isset($_COOKIE["customer_id"]))
    header("location: ./index.html"); 


 include "dbconfig.php";



    $sql = "SELECT * FROM 2022F_patpanka.CUSTOMER WHERE customer_id = " .$_COOKIE['customer_id'];
    
    $result = mysqli_query($conn,$sql); 
    $numRows = mysqli_num_rows($result);

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
    
                echo "<form action ='updateTableCustomer.php' method = 'post'>
                         <TR>
                                <TD bgcolor = yellow > $id </TD>
                                <TD bgcolor = yellow > $login </TD>
                                <TD> <input type = 'text' name = 'password' value = '$password'> </TD> 
                                <TD> <input type = 'text' name = 'lName' value = '$lName' ></TD>
                                <TD> <input type = 'text' name = 'fName' value = '$fName' ></TD>
                                <TD> <input type = 'text' name = 'tel' value = '$tel'></TD>
                                <TD> <input type = 'text' name = 'address' value = '$address'></TD>
                                <TD> <input type = 'text' name = 'city' value = '$city'></TD>
                                <TD> <input type = 'text' name = 'zipcode' value = '$zipcode' </TD>
                                <TD> <select name = 'state' value = '$state' >
                                <option value='$state'></option>
                                <option value='AL'>Alabama</option>
                                <option value='AK'>Alaska</option>
                                <option value='AZ'>Arizona</option>
                                <option value='AR'>Arkansas</option>
                                <option value='CA'>California</option>
                                <option value='CO'>Colorado</option>
                                <option value='CT'>Connecticut</option>
                                <option value='DE'>Delaware</option>
                                <option value='DC'>District Of Columbia</option>
                                <option value='FL'>Florida</option>
                                <option value='GA'>Georgia</option>
                                <option value='HI'>Hawaii</option>
                                <option value='ID'>Idaho</option>
                                <option value='IL'>Illinois</option>
                                <option value='IN'>Indiana</option>
                                <option value='IA'>Iowa</option>
                                <option value='KS'>Kansas</option>
                                <option value='KY'>Kentucky</option>
                                <option value='LA'>Louisiana</option>
                                <option value='ME'>Maine</option>
                                <option value='MD'>Maryland</option>
                                <option value='MA'>Massachusetts</option>
                                <option value='MI'>Michigan</option>
                                <option value='MN'>Minnesota</option>
                                <option value='MS'>Mississippi</option>
                                <option value='MO'>Missouri</option>
                                <option value='MT'>Montana</option>
                                <option value='NE'>Nebraska</option>
                                <option value='NV'>Nevada</option>
                                <option value='NH'>New Hampshire</option>
                                <option value='NJ'>New Jersey</option>
                                <option value='NM'>New Mexico</option>
                                <option value='NY'>New York</option>
                                <option value='NC'>North Carolina</option>
                                <option value='ND'>North Dakota</option>
                                <option value='OH'>Ohio</option>
                                <option value='OK'>Oklahoma</option>
                                <option value='OR'>Oregon</option>
                                <option value='PA'>Pennsylvania</option>
                                <option value='RI'>Rhode Island</option>
                                <option value='SC'>South Carolina</option>
                                <option value='SD'>South Dakota</option>
                                <option value='TN'>Tennessee</option>
                                <option value='TX'>Texas</option>
                                <option value='UT'>Utah</option>
                                <option value='VT'>Vermont</option>
                                <option value='VA'>Virginia</option>
                                <option value='WA'>Washington</option>
                                <option value='WV'>West Virginia</option>
                                <option value='WI'>Wisconsin</option>
                                <option value='WY'>Wyoming</option>
                        </select>  </TD>
            
                        </TR> ";
    
    
            }
            echo "</TABLE>";
            echo "<input type='submit' value='Update Information'>
                  </form>";

            echo "<br> <dr> <a href = 'customerPage.php'> Customer home page</a>";
            echo "<br> <dr> <a href = 'index.html'>Project home page</a>";
        }
        else 
            echo 'There are no records'; 
    }
    else 
        echo "there is something wrong"; 

?>