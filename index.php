<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="styles.css"></link>
    <script src="script.js" defer></script>
</head>

<body>

<?php
    start_session();
    // Obtener datos de incidentes de la base de datos
    $stmt = $pdo->prepare("SELECT * FROM incidents WHERE incident_id = ?");
    $stmt->execute([$incident_id]);
    $incident_data = $stmt->fetch(PDO::FETCH_ASSOC);

    //ip servidor mariadb
    $servername = "192.168.101.60";
    //usuario y password del mariadb
    $username = "webpage";
    $password = "1234";
    $dbname = "incidents";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
        
    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    //usuario y contraseña que llegan del formulario
    $hostname = $_GET["hostname"];
    $user = $_GET["user"];
    $incident_id = $_GET["incident_id"];
    $incident = $_GET["incident"];
    $log_time = $_GET["log_time"];

    // $sql = "SELECT * FROM incidents where hostname = $hostname and user = $user and incident_id = $incident_id and incident = $incident and log_time = $log_time;";

    //enviamos la query a la base de datos
    $datos = mysqli_query($conn, $sql);

    //miramos si los datos tienen mas de 0 fila
    if (mysqli_num_rows($datos) > 0) {
        // output data of each row
        while($fila = mysqli_fetch_assoc($datos)) {
        echo "<h1>id: " . $fila["id"]. " - Name: " . $fila["usuarios"]. " " . $fila["pass"]. "</h1>";
        }
    } else {
        echo "<h1>no ha encontrado el usuario</h1>";
    }

    ?>


<input type="button" id='login-btn' value="Login"></input>
<h1>Página principal</h1>
<div id="data-container">
    <div id="data">

        <p id="data1">nombre de host:<p><?= htmlspecialchars($incident_data['hostname']) ?></p> </p>
        <br>
        <p id="data2">nombre del usuario:<p><?= htmlspecialchars($incident_data['user']) ?></p> </p>
        <br>
        <p id="data3">número de incidente:<p><?= htmlspecialchars($incident_data['incident_id']) ?></p> </p>
        <br>
        <p id="data4">información sobre el incidente:<p><?= htmlspecialchars($incident_data['incident']) ?></p> </p>
        <br>
        <p id="data5">Hora en que se registró el incidente:<p><?= htmlspecialchars($incident_data['log_time']) ?></p> </p>

    </div>
<br>

</div>
</body>
</html>