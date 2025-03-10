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

    // make sure user is logged in
    if(!$_SESSION['login_user']) {
        header("location:login.php");
        exit();
    }
    $keyword = isset($_GET['search']) ? $_GET['search'] : '';

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
        $sqlQuery = "SELECT * FROM incident_logs WHERE incident_status IS NULL OR incident_status = 'Neutral' OR incident_status = 'In process'";
        $data = mysqli_query($conn, $sqlQuery);

        $incident_logs = [];

        if (mysqli_num_rows($data) > 0) {
            while ($row = mysqli_fetch_assoc($data)) {
                $incident_logs[] = $row;
            }
        } else {
            echo "<h1>Error: no incidents found</h1>";
        }
    }

    if ($_SESSION == "") {
        header("Location: login.php");
    }

    /*if ($_SESSION) {
        print_r($_SESSION);
     } else {
        echo "No session";
     }*/

    $_SESSION['redirect'] = 'redirect';

    // Close the connection
    $conn->close();
?>

<!--<a type="button" id='login-btn' value="Login">Login</a>-->
<div id="header">
    <h1>Manejo de incidentes</h1>
    <div id="btn-container">
        <a href="logout.php" id="logout-btn">Sign Out</a>
        <a href="register.php" id="register-btn">Account registration</a>
    </div>
</div>
<div id="main-container">

    <div id="box-container">
            <!-- Search bar -->
            <form action="index.php" method="get" id="search-form">
                <input type="text" placeholder="Search by hostname or user..." name="search" id="search">
                <button type="submit" class="search-btn">Search</button>
            </form>

        <!-- Shows all reported incidents.--> 
        <div id="incident_selector_container">
            <?php foreach ($incident_logs as $incidents): ?>
                <button class="incident_selector <?= $incidents['incident_status'] === 'In process' ? 'in_process' : ($incidents['incident_status'] === 'Neutral' ? 'neutral' : '') ?>"
                    data-incident-id="<?= htmlspecialchars($incidents['incident_id']) ?>"
                    data-hostname="<?= htmlspecialchars($incidents['hostname']) ?>"
                    data-user="<?= htmlspecialchars($incidents['user']) ?>"
                    data-incident="<?= htmlspecialchars($incidents['incident']) ?>"
                    data-log-time="<?= htmlspecialchars($incidents['log_time']) ?>">
                    <?= htmlspecialchars($incidents['hostname'])?>
                    <br>
                    <?= "id_" . htmlspecialchars($incidents['incident_id'])?>
                    <?= htmlspecialchars($incidents['user'])?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>



    <!-- Holds all data retrieved from database -->
        <div id="data-container">
            <!--displays user's last search query-->
            <h2 id="last_search">Last search: <?= htmlspecialchars($keyword) ?></h2>
            <div id="data">

            <form action="submit.php?selected_incident_id=<?= isset($_GET['selected_incident_id']) ? htmlspecialchars($_GET['selected_incident_id']) : '' ?>" method="post" name="incident_form" id="incident_form">
                    <input type="hidden" name="hostname" value="">
                    <input type="hidden" name="user" value="">
                    <input type="hidden" name="incident_id" value="">
                    <input type="hidden" name="incident" value="">
                    <input type="hidden" name="log_time" value="">
                    <input type="hidden" name="incident_status" value="">
                    <input type="hidden" name="selected_incident_id" id="selected_incident_id" value="<?= isset($_GET['selected_incident_id']) ? htmlspecialchars($_GET['selected_incident_id']) : '' ?>">
                    <input type="hidden" name="feedback" id="feedback">
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
                    <textarea id="details" name="details" rows="4" placeholder="Feedback on incident (sent upon conclusion)"></textarea>
                    <div id="status-btns">
                        <input type="submit" value="Conclude incident" id="concluir" class="form_button concluir">
                        <input type="submit" value="In process" id="proceso" class="form_button proceso">
                        <input type="submit" value="Neutral" id="neutral" class="form_button neutral">
                    </div>
                </form>

            </div>
            <br>
        </div>
</div>
</body>
</html>