<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $db_host = 'localhost';
    // $db_host = '24.218.80.27';
    $db_user = 'uvczuhuvy5yze';
    $db_pass = 'inpqyygxomsu';
    $db_name = 'db8gbnzanqq4w5';

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
?>