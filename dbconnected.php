<?php
    $host   = "localhost";
    $user   = "root";
    $pass   = "";
    $dbname = "financefutsal";

    $conn   = new mysqli($host, $user, $pass, $dbname);

    if($conn->connect_error){
        die("Sambungan Ke Database Gagal: " . $conn->connect_error);
    }

?>
