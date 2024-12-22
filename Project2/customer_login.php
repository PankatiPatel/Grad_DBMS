<HTML>
    <font size=4><b>Customer login</b></font>
    <form name="input" action="customer_authen.php" method="post" >
    <br> Login ID: <input type="text" name="login" requierd>
    <br> Password: <input type="password" name="password" requierd>
    <input type="submit" value="Login">
    </form>
</HTML>


<?php

if(isset($_COOKIE['customer_id']))
    header('location: customer_check_p2.php');

?>