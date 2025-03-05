<?php
require_once 'dbconnection.php';

// Receives form data
$details = isset($_POST['details']) ? $_POST['details'] : '';
$incident_id = isset($_POST['incident_id']) ? $_POST['incident_id'] : '';
$incident_status = isset($_POST['incident_status']) ? $_POST['incident_status'] : '';

// Prepares the SQL query to update incident_status
$sqlUpdate = "UPDATE incident_logs SET incident_status = ?, details = ? WHERE incident_id = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("ssi", $incident_status, $details, $incident_id);

// Update incident_status in the database
if ($stmtUpdate->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

// Update incident_status in the database
/*$response = [];
if ($stmtUpdate->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Incident status updated successfully.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error updating incident status: ' . $conn->error;
}

header('Content-Type: application/json');
echo json_encode($response);*/
?>