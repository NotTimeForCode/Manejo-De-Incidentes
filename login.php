<?php
   require_once 'dbconnection.php';

   $error = '';
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       // Get the username and password from the form
       $myusername = mysqli_real_escape_string($conn, $_POST['username']);
       $mypassword = mysqli_real_escape_string($conn, $_POST['password']);
   
       // Prepare the SQL query to get the hashed password from the database
       $sql = "SELECT * FROM users WHERE username = '$myusername'";
       $result = mysqli_query($conn, $sql);
       $row = mysqli_fetch_assoc($result);
   
       // Check if the user exists and verify the password
       if ($row && password_verify($mypassword, $row['password'])) {
           // Password is correct, start a session and redirect to the index page
           session_start();
           $_SESSION['login_user'] = $myusername;
           header("location: index.php");
       } else {
           // Invalid username or password
           $error = "Your Login Name or Password is invalid";
       }
   
       // Close the connection
       mysqli_close($conn);
   }
   
      if (!$_SESSION) {
         print_r($_SESSION);
      } else {
         echo "No session";
      }
?>
<html>
<head>
   <title>Login Page</title>
   <style type = "text/css">
      body {
         font-family:Arial, Helvetica, sans-serif;
         font-size:14px;
         background-color: rgb(197, 197, 197);

      }
      label {
         font-weight:bold;
         width:100px;
         font-size:14px;
      }
      .box {
         border:#666666 solid 1px;
      }
   </style>
</head>
<body>
   <div align = "center">
      <div style = "width:300px; border: solid 1px #333333; " align = "left">
         <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
         <div style = "margin:30px">
            <form action = "" method = "post">
               <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
               <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
               <input type = "submit" value = " Submit "/><br />
            </form>
            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
         </div>
      </div>
   </div>
</body>
</html>