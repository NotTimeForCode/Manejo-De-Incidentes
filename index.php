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

    //look if the query has more than 0 rows
    if (mysqli_num_rows($data) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($data)) {
        echo "<h3> Hostname: " . $row["hostname"].  " User: " . $row["user"]. " id: " . $row["incident_id"]. " incident: " . $row["incident"]. " log time: " . $row["log_time"]. "</h3>";
        $hostname = $row["hostname"];
        $user = $row["user"];
        $incident_id = $row["incident_id"];
        $incident = $row["incident"];
        $log_time = $row["log_time"];
    }
    } else {
        echo "<h1>didnt work</h1>";
    }

?>


<input type="button" id='login-btn' value="Login">
<h1>Página principal</h1>

<div id="main-container">
    <!-- Shows all reported incidents.--> 

    <!--Write foreach to create a button for every single incident_id in DB
    if clicked, leave button highlighted-->
    <div id="incident_selector_container">

        <button class="incident_selector">Incident_1</button>
        <button class="incident_selector">Incident_2</button>
        <button class="incident_selector">Incident_3</button>
        <button class="incident_selector">Incident_4</button>
        <button class="incident_selector">Incident_5</button>
        <button class="incident_selector">Incident_6</button>
        <button class="incident_selector">Incident_7</button>
        <button class="incident_selector">Incident_8</button>
        <button class="incident_selector">Incident_9</button>
        <button class="incident_selector">Incident_10</button>
        <button class="incident_selector">Incident_11</button>
        <button class="incident_selector">Incident_12</button>
        <button class="incident_selector">Incident_13</button>
        <button class="incident_selector">Incident_14</button>


    </div>
 
    <!-- Holds all data retrieved from database -->
    <div id="data-container">
        <div id="data">

            <p id="data1">nombre de host: <?= htmlspecialchars($hostname) ?></p>
            <br>
            <p id="data2">nombre del usuario: <?= htmlspecialchars($user) ?></p>
            <br>
            <p id="data3">número de incidente: <?= htmlspecialchars($incident_id) ?></p>
            <br>
            <p id="data4">información sobre el incidente: <?= htmlspecialchars($incident) ?></p>
            <br>
            <p id="data5">Hora en que se registró el incidente: <?= htmlspecialchars($log_time) ?></p>

            <form action="submit.php" method="post">
                <input type="hidden" name="incident_id" value="<?= $incident_id ?>">
                <input type="text" name="comentario" id="comentario" placeholder="Retroalimentación sobre el incidente...">
                <input type="submit" value="Enviar" id="enviar">
            </form>
        </div>
    <br>
</div>

</div>
</body>
</html>