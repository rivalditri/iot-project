<?php

    //Variabel database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sensor";

    $conn = mysqli_connect("$servername", "$username", "$password","$dbname");

    // Prepare the SQL statement
    
    $result = mysqli_query ($conn,"INSERT INTO datasensor (data, alert) VALUES ('".$_GET["data"]."', '".$_GET["sensor"]."')");    
    
    if (!$result) 
        {
            die ('Invalid query: '.mysqli_error($conn));
        }  
?>