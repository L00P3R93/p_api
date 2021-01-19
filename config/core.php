<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    date_default_timezone_set('Africa/Nairobi');

    $key = ""; //Set a unique Key
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60); //valid for 1 hour
    $issuer = "http://localhost/api/syntaks/";


    $home_url="http://localhost/api/";

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $records_per_page = 5;
    $from_record_num = ($records_per_page * $page) - $records_per_page;
