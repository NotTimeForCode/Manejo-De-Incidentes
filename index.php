<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manejo de incidentes</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>
    
<?php
    require_once 'session.php';

    // Prevent chaching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $error = '';
    // If redirect variable is not set redirect to login page
    if (!isset($_SESSION['redirect']) || $_SESSION['redirect'] !== 'redirect') {
        header("Location:login.php");
        exit();
    }
    // Set redirect variable
    $_SESSION['redirect'] = 'redirect';

    // make sure user is logged in
    if(!$_SESSION['login_user']) {
        header("location:login.php");
        exit();
    }
    $keyword = isset($_GET['search']) ? $_GET['search'] : '';
    // Function for searching incidents
    if ($keyword) {
        // Prepare the SQL query to search based on hostname and user
        $sqlQuery = "SELECT * FROM `incident_logs` WHERE `hostname` LIKE ? OR `user` LIKE ? ORDER BY `hostname`";
        $stmt = $conn->prepare($sqlQuery);
        $searchTerm = '%' . $keyword . '%';
        $stmt->bind_param('ss', $searchTerm, $searchTerm);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the results
        $incident_logs = [];
        while ($row = $result->fetch_assoc()) {
            $incident_logs[] = $row;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Displays all available incidents if no search term is provided
            $sqlQuery = "SELECT * FROM incident_logs WHERE incident_status IS NULL OR incident_status = 'Neutral' OR incident_status = 'In process'";
            $data = mysqli_query($conn, $sqlQuery);

            $incident_logs = [];

            // Checks if there are any incidents in the database
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_assoc($data)) {
                    $incident_logs[] = $row;
                }
            } else {
                $error = "Error: no incidents found";
            }
        }
        // If session variable doesn't exist, redirect to login page
        if ($_SESSION == "") {
            header("Location: login.php");
        }

        /*if ($_SESSION) {
            print_r($_SESSION);
        } else {
            echo "No session";
        }*/

        // Close the connection
        $conn->close();
    ?>

    <!-- Top-nav -->
<div id="header">
    <h1>Manejo de incidentes</h1>
    <div id="btn-container">
        <a href="logout.php" id="logout-btn">Desconectar</a>
        <a href="register.php" id="register-btn">Registro de cuenta</a>
    </div>
</div>

    <!--container for website content-->
<div id="main-container">

            <!-- Search bar -->
        <div class="bar-container">
            <form action="index.php" method="get" id="search-form">
                <input type="text" placeholder="Buscar por nombre de host o usuario..." name="search" id="search">
                <button type="submit" class="search-btn">Buscar</button>
            </form>
        </div>

            <!-- Shows all reported incidents.--> 
        <div id="box-container">
        <div class="container-container">
        <div id="incident_selector_container">
            
                <div class="incident_error"><?= $error ?></div>
        <!-- Creates a button for every logged and unconcluded incident -->
            <?php foreach ($incident_logs as $incidents): ?>
                <button class="incident_selector <?= $incidents['incident_status'] === 'In process' ? 'in_process' : ($incidents['incident_status'] === 'NULL' ? 'null' : '') ?>"
                    data-incident-id="<?= htmlspecialchars($incidents['incident_id']) ?>"
                    data-hostname="<?= htmlspecialchars($incidents['hostname']) ?>"
                    data-user="<?= htmlspecialchars($incidents['user']) ?>"
                    data-incident="<?= htmlspecialchars($incidents['incident']) ?>"
                    data-log-time="<?= htmlspecialchars($incidents['log_time']) ?>"
                    data-incident-status="<?= htmlspecialchars($incidents['incident_status']) ?>">
                    <?= htmlspecialchars($incidents['hostname'])?>
                    <br>
                    <?= "id_" . htmlspecialchars($incidents['incident_id'])?>
                    <?= htmlspecialchars($incidents['user'])?>
                </button>
            <?php endforeach; ?>
        </div>
        </div>
    </div>



 
        
            <!--displays user's last search query-->
            <div class="search-container">
                <h2 id="last_search">Última búsqueda: <?= htmlspecialchars($keyword) ?></h2>
            </div>

               <!-- Holds all data retrieved from database -->
            <div id="data-container">
            <div class="container-container">

            <div id="data">
            <form action="submit.php?selected_incident_id=<?= isset($_GET['selected_incident_id']) ? htmlspecialchars($_GET['selected_incident_id']) : '' ?>" method="post" name="incident_form" id="incident_form">
                <!-- Holds values to be to be logged -->
                    <input type="hidden" name="hostname" value="">
                    <input type="hidden" name="user" value="">
                    <input type="hidden" name="incident_id" value="">
                    <input type="hidden" name="incident" value="">
                    <input type="hidden" name="log_time" value="">
                    <input type="hidden" name="incident_status" value="">
                    <input type="hidden" name="selected_incident_id" id="selected_incident_id" value="<?= isset($_GET['selected_incident_id']) ? htmlspecialchars($_GET['selected_incident_id']) : '' ?>">
                    <input type="hidden" name="feedback" id="feedback">

                <!-- Data is displayed here -->
                    <h2 id="data1">nombre de host: </h2>
                    <br>
                    <h4 id="data2">nombre del usuario: </h4>
                    <br>
                    <h4 id="data3">número de incidente: </h4>
                    <br>
                    <h4 id="data4">información sobre el incidente: </h4>
                    <br>
                    <h4 id="data5">Hora en que se registró el incidente: </h4>
                    <br>
                    <textarea id="details" name="details" rows="4" placeholder="Comentarios sobre el incidente (enviados al concluir)"></textarea>
                    <div id="status-btns">
                    <!-- Conclude button sets incident as Concluded and it is no longer displayed on the website -->
                        <input type="submit" value="Concluir incidente" id="concluir" class="form_button concluir">
                    <!-- In process button sets incident as In process and it is displayed with dotted borders and yellow background on the website -->
                        <input type="submit" value="En proceso" id="proceso" class="form_button proceso">
                    </div>
                </form>

            </div>
            </div>
            <br>
        </div>
</div>
</body>
</html>