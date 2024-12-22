<?php

    unset($_COOKIE["customer_id"]);
    setcookie("customer_id",'', time() - 3600,"/");
    header("location: ../index.html");
    
    unset($_COOKIE["search_keyword"]);
    setcookie("search_keyword",$search , time() - 3600,"/");
?>