<?php 

include("dbconfig.php"); 

$view_emp = "SELECT * FROM CPS5740.EMPLOYEE"; 

$view_emp_result = mysqli_query($conn, $view_emp); 
$view_emp_numRows = mysqli_num_rows($view_emp_result); 


if($view_emp_result)
{
   if($view_emp_numRows > 0 )
    {
        echo "The following employees are in the database";
        echo  "<TABLE border=1>
        <TR>
            <TH>ID</TH>
            <TH>Login </TH>
            <TH>Password </TH>
            <TH>Name</TH>
            <TH>Role </TH>
        </TR>";

          while($row = mysqli_fetch_array($view_emp_result))
          {

                $emp_id = $row["employee_id"];
                $emp_login = $row["login"];
                $emp_pwd = $row["password"]; 
                $emp_name = $row["name"]; 
                $role = $row["role"]; 

                echo "<TR>
                <TD> $emp_id </TD>
                <TD> $emp_login </TD>
                <TD> $emp_pwd </TD> 
                <TD> $emp_name </TD>
                <TD> $role </TD>
             </TR> ";
          }
          echo "</TABLE>";

    }
    else 
        echo "There are no records";
}
else 
    echo "There is an issue";

?>