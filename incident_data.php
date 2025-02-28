<?php
require_once 'dbconnection.php';

if (isset($_GET['incident_id'])) {
    $incident_id = intval($_GET['incident_id']);
    $sqlQuery = "SELECT * FROM incident_logs WHERE incident_id = $incident_id";
    $result = mysqli_query($conn, $sqlQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $incident = mysqli_fetch_assoc($result);
        echo json_encode($incident);
    } else {
        echo json_encode(['error' => 'Incident not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid incident ID']);
}
