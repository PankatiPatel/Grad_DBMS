<?php
        include ("dbconfig.php"); 
        date_default_timezone_set('America/New_York');
        
        $state = "SELECT * FROM 2022F_patpanka.STATES";
        $result = mysqli_query($conn,$state);
?>
<HTML>
    <font size=4><b>Customer sign up</b></font>
    <form name="input" action="customer_insert.php" method="post" >
    <br> Login ID: <input type="text" name="login" required="required">
    <br> Password: <input type="password" name="passwd1" required="required">
    <br> Retype Password: <input type="password" name="passwd2" required="required">
    <br> First Name: <input type="text" name="first_name" required="required">
    <br> Last Name: <input type="text" name="last_name" required="required">
    <br> TEL: <input type="tel" name="tel" required placeholder="1234557890" pattern="[0-9]{3}[0-9]{3}[0-9]{4}">
    <br> Address<input type="text" name="address" required="required" placeholder="123 Main st">
    <br> City: <input type="text" name="city" required="required" placeholder="Union">
    <br> Zipcode: <input type="text" name="zipcode" required="required" title = "Pleas enter valid zipcode" placeholder="00000" pattern="[0-9]{5}">
    <br> State:
    <select name="state" required="required">
            <option value=''></option>
            <?php
                while($row = mysqli_fetch_array($result))
                {
                        echo '<option value = "' .$row["Code"]. '">'.$row["State"].'</option>';
                }
            ?>
     
    </select>
    <input type="submit" value="Sign up">
    </form>
    </HTML>
    
    