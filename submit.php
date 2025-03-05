<?php
require_once 'dbconnection.php';

// Receives form data
$details = isset($_POST['details']) ? $_POST['details'] : '';
$incident_id = isset($_POST['incident_id']) ? $_POST['incident_id'] : '';
$incident_status = isset($_POST['incident_status']) ? $_POST['incident_status'] : '';

// Debugging: Log received form data
error_log("Received form data: details=$details, incident_id=$incident_id, incident_status=$incident_status");

// Check if required data is received
if (empty($incident_id) || empty($incident_status)) {
    echo "Error: Missing required form data.";
    exit();
}

// Prepares the SQL query to update incident_status
$sqlUpdate = "UPDATE incident_logs SET incident_status = ?, details = ? WHERE incident_id = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);

// Check if the statement was prepared successfully
if (!$stmtUpdate) {
    error_log("Error preparing statement: " . $conn->error);
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmtUpdate->bind_param("ssi", $incident_status, $details, $incident_id);

// Update incident_status in the database
if ($stmtUpdate->execute()) {
    error_log("Record updated successfully");
    header("Location: index.php");
    exit();
} else {
    error_log("Error updating record: " . $stmtUpdate->error);
    echo "Error updating record: " . $stmtUpdate->error;
}
?>