<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>

<?php
    require_once 'dbconnection.php';

    $sqlQuery = "SELECT * FROM incident_logs;";
    
    //send the query
    $data = mysqli_query($conn, $sqlQuery);

    $incident_logs = [];

    //look if the query has more than 0 rows
    if (mysqli_num_rows($data) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($data)) {
        // echo "<h3> Hostname: " . $row["hostname"].  " User: " . $row["user"]. " id: " . $row["incident_id"]. " incident: " . $row["incident"]. " log time: " . $row["log_time"]. "</h3>";
        $hostname = $row["hostname"];
        $user = $row["user"];
        $incident_id = $row["incident_id"];
        $incident = $row["incident"];
        $log_time = $row["log_time"];
        $incident_logs[] = $row;
    }
    
    } else {
        echo "<h1>Error: line 37</h1>";
    }

?>


<input type="button" id='login-btn' value="Login">
<h1>Manejo de incidentes</h1>

<div id="main-container">

    <!-- Shows all reported incidents.--> 
    <div id="incident_selector_container">
        <?php foreach ($incident_logs as $incidents): ?>
            <button class="incident_selector"
                data-incident-id="<?= htmlspecialchars($incidents['incident_id']) ?>"
                data-hostname="<?= htmlspecialchars($incidents['hostname']) ?>"
                data-user="<?= htmlspecialchars($incidents['user']) ?>"
                data-incident="<?= htmlspecialchars($incidents['incident']) ?>"
                data-log-time="<?= htmlspecialchars($incidents['log_time']) ?>">
                <?="Incident_" . htmlspecialchars($incidents['incident_id'])?>
                <?= htmlspecialchars($incidents['hostname'])?>
            </button>

        <?php endforeach; ?>
    </div>

    <div id="box-container">

    <!-- Search bar -->
    <form action="index.php">
      <input type="text" placeholder="Search.." name="search" id="search">
      <button type="submit"class="search-btn">Search</button>
    </form>

    <!-- Holds all data retrieved from database -->
        <div id="data-container">
            <div id="data">

                <form action="submit.php" method="post" name="incident_form" id="incident_form">
                    <input type="hidden" name="hostname" value="">
                    <input type="hidden" name="user" value="">
                    <input type="hidden" name="incident_id" value="">
                    <input type="hidden" name="incident" value="">
                    <input type="hidden" name="log_time" value="">
                    <p id="data1">nombre de host: </p>
                    <br>
                    <p id="data2">nombre del usuario: </p>
                    <br>
                    <p id="data3">número de incidente: </p>
                    <br>
                    <p id="data4">información sobre el incidente: </p>
                    <br>
                    <p id="data5">Hora en que se registró el incidente: </p>
                    <br>
                    <textarea id="details" name="details" rows="4" placeholder="Retroalimentación sobre el incidente..."></textarea>
                    <div id="status-btns">
                        <input type="submit" value="Concluir incidente" class="form_button concluir">
                        <input type="submit" value="En proceso" class="form_button proceso">
                    </div>
                </form>

            </div>
            <br>
        </div>
    </div>
</div>
</body>
</html>