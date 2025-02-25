<?php 
    session_start();

    //ip servidor mariadb
    $servername = "127.0.0.1:3308";
    //usuario y password del mariadb
    $username = "root";
    $password = "";
    $dbname = "incidents";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
        
    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }