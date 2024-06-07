<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database_name = "peminjaman_buku";

    $db = mysqli_connect(
        $hostname, $username, $password, $database_name);

    if($db->connect_error) {
        echo "Database tidak ditemukan";
        die("Error!!!");
    }
?>