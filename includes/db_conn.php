<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cta_schema";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if(!$conn) {
        die("Error: Connection Failed. " . mysqli_connect_error());
    }
    
?>