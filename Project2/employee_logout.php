<?php
unset($_COOKIE["emp_mang_id"]);
setcookie("emp_mang_id",'', time() - 60,"/");
header("location: ../index.html");


?>