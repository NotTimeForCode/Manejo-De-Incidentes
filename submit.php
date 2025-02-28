<?php
require_once 'dbconnection.php';

// Receives form data
$hostname = isset($_POST['hostname']) ? $_POST['hostname'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$incident_id = isset($_POST['incident_id']) ? $_POST['incident_id'] : '';
$incident = isset($_POST['incident']) ? $_POST['incident'] : '';
$log_time = isset($_POST['log_time']) ? $_POST['log_time'] : '';
$details = isset($_POST['details']) ? $_POST['details'] : '';

// Prepares the SQL query
$sqlInsert = "INSERT INTO concluded_incidents (hostname, user, incident_id, incident, log_time, details) 
VALUES (?, ?, ?, ?, ?, ?)";

$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bind_param("ssisss", $hostname, $user, $incident_id, $incident, $log_time, $details);

// Add data to the database
    if ($stmtInsert->execute()) {

       /* $sqlDelete = "DELETE FROM incident_logs WHERE incident_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $incident_id);
    
        if ($stmtDelete->execute()) {
            header("Location: index.php");
            exit();                                 // uncomment when program is finished
        } else {
            echo "Error deleting record: " . $conn->error;
        }*/
        header("Location: index.php");
    } else {
        echo "Error inserting record: " . $conn->error;
    }
