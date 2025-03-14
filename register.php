<?php
    require_once 'session.php';
    if(!isset($login_session)) {
        echo 'You are already logged in';
        header("Location: index.php");
        exit();
    }

    $_success_message = '';
    $_error_message = isset($_GET['error']) ? $_GET['error'] : '';
    $_success_message = isset($_GET['success']) ? $_GET['success'] : '';


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

     $_SESSION['redirect'] = 'redirect';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    
    <div id="main-container">
        <div class="login-container">
      <div class="log-container">
         <div class="login-header"><b>Register user account</b></div>
         <div class="login-form-container">
            <form action="createuser.php" method="post">
               <label>Username:</label><input type="text" name="username" id="username" minlength="3" maxlength="70" /><br><br>
               <label>Password:</label><input type="password" name="password" id="password" minlength="5" maxlength="70" /><br><br>
               <div class="btn-row">
               <input class="submit-btn" type="submit" name="submit" value=" Register "/><br>
                    <div class="submit-btn-container">
                        <a href="index.php" class="submit-btn">Return</a>
                    </div>
                </div>
               <br>
            </form> 
        <div class="error_message"><?= $_error_message ?></div>
        <div class="success_message"><?= $_success_message ?></div>
        </div>
      </div>
   </div>
    </div>

    <script>
        // Remove URL parameters after page reload
    if (window.location.search.length > 0) {
      const url = new URL(window.location);
      url.search = '';
      window.history.replaceState({}, document.title, url.toString());
    }
    </script>

</body>
</html>