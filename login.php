<?php
   require_once 'dbconnection.php';

   if (isset($_COOKIE['username']) && isset($_COOKIE['token'])) {
       $username = $_COOKIE['username'];
       $token = $_COOKIE['token'];
   
       // Retrieve the hashed token from the database
       $res = mysqli_query($conn, "SELECT token FROM users WHERE username='$username'");
       if (mysqli_num_rows($res)) {
           $row = mysqli_fetch_assoc($res);
           $hashed_token = $row['token'];
   
           // Verify the token
           if (password_verify($token, $hashed_token)) {
               $_SESSION['login_user'] = 'yes';
               header('location:index.php');
               exit();
           }
       }
   }

   $error = '';
   $default_message = 'no redirection';
   $msg='';

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Lockout parameters
      $lock_time = 60; // seconds
      $time_limit = time() - $lock_time;
      $ip_address = getIpAddr();

      // Getting Post Values
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $remember = isset($_POST['remember']);
      
      // Get count of failed login attempts within the lock period
      $query = mysqli_query($conn, "SELECT COUNT(*) as total_count FROM loginlogs WHERE TryTime > $time_limit AND IpAddress='$ip_address' AND username='$username'");
      $check_login_row = mysqli_fetch_assoc($query);
      $total_count = $check_login_row['total_count'];
      
      if ($total_count >= 3) {
         // If attempts exceed the limit, do not process login
         //$msg = "Too many failed login attempts. Please try again after $lock_time seconds.";
         $_SESSION['msg'] = "Too many failed login attempts. Please try again after $lock_time seconds.";

      } else {


         if ($username == '' || $password == '') {
            //$error = 'Please enter a username and password';
            $_SESSION['error'] = 'Please enter a username and password';

         } else {
            // Coding for login
            $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
            if (mysqli_num_rows($res)) {
               $row = mysqli_fetch_assoc($res);
               if (password_verify($password, $row['password'])) {
                  $_SESSION['login_user'] = 'yes';
                  mysqli_query($conn, "DELETE FROM loginlogs WHERE IpAddress='$ip_address' AND username='$username'");
                  
                  // Set cookies if "Remember Me" is checked
                  if ($remember) {
                     $token = bin2hex(random_bytes(16)); // Generate a random token
                     setcookie('username', $username, time() + (86400 * 7), "/"); // 30 days
                     setcookie('token', $token, time() + (86400 * 7), "/"); // 30 days
                     
                     // Store the token in the database
                     $hashed_token = password_hash($token, PASSWORD_DEFAULT);
                     mysqli_query($conn, "UPDATE users SET token='$hashed_token' WHERE username='$username'");
                  }
                  
                  header('location:index.php');
                  exit();
               } else {
                  // Increment count and compute remaining attempts
                  $total_count++;
                  $rem_attm = 3 - $total_count;
                  
                  if ($rem_attm <= 0) {
                     //$msg = "Too many failed login attempts. Please try again after $lock_time seconds.";
                     $_SESSION['msg'] = "Too many failed login attempts. Please try again after $lock_time seconds.";
                  } else {                  
                    //$msg = "Please enter valid login details. $rem_attm attempts remaining.";
                     $_SESSION['msg'] = "Please enter valid login details. $rem_attm attempts remaining.";

                  }
                  $try_time = time();
                  mysqli_query($conn, "INSERT INTO loginlogs(IpAddress, TryTime, username) VALUES('$ip_address', '$try_time', '$username')");
               }
            } else {
               //$msg = "Please enter valid login details.";
               $_SESSION['msg'] = "Please enter valid login details.";
            }
         }
      }
      header('Location: login.php');
      exit();
   }
   
   // Getting IP Address
   function getIpAddr(){
      if (!empty($_SERVER['HTTP_CLIENT_IP'])){
         $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
      }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
         $ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
      }else{
         $ipAddr=$_SERVER['REMOTE_ADDR'];
      }
      return $ipAddr;
   }

   // Close the connection
   mysqli_close($conn);

   $_SESSION['redirect'] = 'redirect';
?>
<html>
<head>
   <title>Login Page</title>
   <link rel="stylesheet" href="styles.css">
</head>
<body>
   <div class="login-container">
      <div class="log-container">
         <div class="login-header"><b>Acceso</b></div>
         <div class="login-form-container">
            <form action="login.php" method="post">
               <label>Usuario:   </label><input type="text" name="username" class="box" id="username"/><br><br>
               <label>Contrasena:</label><input type="password" name="password" class="box" id="password"/><br><br>
               <input type="checkbox" name="remember" id="remember"> Acuérdate de mí<br><br>
               <input type="submit" name="submit" value=" Entregar "/><br>
            </form>

            <div class="login-error-container"><?= isset($_SESSION['error']) ? $_SESSION['error'] : ''; unset($_SESSION['error']); ?></div>
            <div id="result"><?= isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; unset($_SESSION['msg']); ?></div>
         </div>
      </div>
   </div>
</body>
</html>