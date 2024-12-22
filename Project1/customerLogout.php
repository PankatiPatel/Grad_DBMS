<?php

    unset($_COOKIE["customer_id"]);
    setcookie("customer_id",'', time() - 60,"/");
    header("location: ./index.html");
    
?>