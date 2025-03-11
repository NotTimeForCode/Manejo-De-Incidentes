<?php
    require_once 'session.php';
    if(!isset($login_session)) {
        echo 'You are already logged in';
        header("Location: index.php");
        exit();
    }

    $_error_message = isset($_GET['error']) ? $_GET['error'] : '';

    if (!isset($_SESSION['redirect']) || $_SESSION['redirect'] !== 'redirect') {
        header("Location: login.php");
        exit();
    }
    /*setcookie("user", "John Doe", time() + (7 * 24 * 60 * 60), "/");    
    $_COOKIE["user"];*/

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

    <?= $_error_message ?>

    <div id="main-container">

        <h2>Register</h2>

        <form action="createuser.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br><br> <!-- minlength="4" maxlength="30" -->
            
                                                 <!-- Remember to set minimum and maximum characterlimits on inputfields  -->

            <label for="password">Password:</label><br>                
            <input type="password" id="password" name="password"><br><br> <!-- minlength="4" maxlength="50" -->

            <input type="submit" value="Register">
        </form>
        <br>
        <a href="index.php">Return</a>
    </div>
</body>
</html>