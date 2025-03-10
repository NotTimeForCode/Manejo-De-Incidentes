<?php
    require_once 'session.php';
    if(!isset($login_session)) {
        echo 'You are already logged in';
        header("Location: index.php");
        exit();
    }

    if (!isset($_SESSION['redirect']) || $_SESSION['redirect'] !== 'redirect') {
        header("Location: login.php");
        exit();
    }

    unset($_SESSION["redirect"]);

        /*if ($_SESSION) {
        print_r($_SESSION);
     } else {
        echo "No session";
     }*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <div id="main-container">

        <h2>Register</h2>

        <form action="createuser.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Register">
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
        <a href="index.php">Return</a>
    </div>
</body>
</html>