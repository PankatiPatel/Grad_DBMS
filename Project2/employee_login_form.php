

<HTML>


    <font size=4><b>Employee login</b></font>
    
    <form name="input" action="employee_authen.php" method="post" >
    <br> Login ID: <input type="text" name="login" required = "required" value >
    <br> Password: <input type="password" name="password" required>
    <input type="submit" value="Login">
    </form>
    
    </HTML>
    

    <?php 

        if(isset($_COOKIE['emp_mang_id']))
            header('location: employee_login.php');

    ?>
    
    