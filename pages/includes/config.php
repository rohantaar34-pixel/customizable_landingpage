<?php


function conn()
{
    // $host = 'localhost';
    // $dbname = 'u469776567_inandout';
    // $username = 'u469776567_iao';
    // $password = '^;yJpD3yjOe5';sssssss
    $host = 'localhost';
    $dbname = 'inandout';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo $conn->connect_error;
    } else {
        return $conn;
    }
}

?>