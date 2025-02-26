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

    // Compruebe si los parámetros GET necesarios están configurados
if (isset($_GET["hostname"], $_GET["user"], $_GET["incident_id"], $_GET["incident"], $_GET["log_time"])) {
    //usuario y contraseña que llegan del formulario
    $hostname = $_GET["hostname"];
    $user = $_GET["user"];
    $incident_id = $_GET["incident_id"];
    $incident = $_GET["incident"];
    $log_time = $_GET["log_time"];
} else {
    die("Faltan parámetros obligatorios.");
}

    // Obtener datos de incidentes de la base de datos 
    $stmt = $conn->prepare("SELECT * FROM incident_logs WHERE incident_id = ?");
    $stmt->bind_param("i", $incident_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $incident_data = $result->fetch_assoc();

    if (!$incident_data) {
        die("No se encontró ningún incidente con el ID proporcionado.");
    }

    // Use a prepared statement to search for data based on username and password
    $stmt = $conn->prepare("SELECT * FROM incident_logs WHERE account = ? AND pass = ?");
    $stmt->bind_param("ss", $account, $pass);
    $stmt->execute();
    $datos = $stmt->get_result();
    
    $account = $_GET["account"];
    $pass = $_GET["pass"];

    //$sqlQuery2 = "SELECT * FROM incident_logs where account = $account and pass = $pass;";

    // enviamos la query a la base de datos
    $datos = mysqli_query($conn, $sqlQuery2);

    //miramos si los datos tienen mas de 0 fila
    if (mysqli_num_rows($datos) > 0) {
        // output data of each row
        while($fila = mysqli_fetch_assoc($datos)) {
            echo "<h1>id: " . htmlspecialchars($fila["incident_id"]) . " - Name: " . htmlspecialchars($fila["account"]) . " " . htmlspecialchars($fila["password"]) . "</h1>";
        }
    } else {
        echo "<h1>no ha encontrado el usuario</h1>";
    }

    // Declaración preparada para evitar la inyección SQL
    $sql = "SELECT * FROM incident_logs";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $hostname, $user, $incident_id, $incident, $log_time);
    $stmt->execute();
    $datos = $stmt->get_result();

    $stmt->close();
    $conn->close();

    ?>


<input type="button" id='login-btn' value="Login">
<h1>Página principal</h1>
<div id="data-container">
    <div id="data">

        <p id="data1">nombre de host: <?= htmlspecialchars($incident_data['hostname']) ?></p>
        <br>
        <p id="data2">nombre del usuario: <?= htmlspecialchars($incident_data['user']) ?></p>
        <br>
        <p id="data3">número de incidente: <?= htmlspecialchars($incident_data['incident_id']) ?></p>
        <br>
        <p id="data4">información sobre el incidente: <?= htmlspecialchars($incident_data['incident']) ?></p>
        <br>
        <p id="data5">Hora en que se registró el incidente: <?= htmlspecialchars($incident_data['log_time']) ?></p>
        
        <form action="submit.php" method="post">
            <input type="hidden" name="incident_id" value="<?= $incident_id ?>">
            <input type="text" name="comentario" id="comentario" value="Retroalimentación sobre el incidente...">
            <input type="submit" value="Enviar" id="enviar">
        </form>
    </div>
    <br>

</div>
</body>
</html>