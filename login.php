<?php
   require_once 'dbconnection.php';

   $error = '';
   $_success_message = ''; // Initialize the variable
   $default_message = 'no redirection';
   $_success_message = isset($_GET['success']) ? $_GET['success'] : '';
   $msg='';
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {

      
      // Get the username and password from the form
      $myusername = mysqli_real_escape_string($conn, $_POST['username']);
      $mypassword = mysqli_real_escape_string($conn, $_POST['password']);

      if ($myusername == '' || $mypassword == '') {
         $error = 'Please enter a username and password';
      } else {
            // Prepare the SQL query to get the hashed password from the database
         $sql = "SELECT * FROM users WHERE username = '$myusername'";
         $result = mysqli_query($conn, $sql);
         $row = mysqli_fetch_assoc($result);

         // Check if the user exists and verify the password
         if ($row && password_verify($mypassword, $row['password'])) {
             // Password is correct, start a session and redirect to the index page
             $_SESSION['login_user'] = $myusername;
             header("location: index.php");
             exit();
         } else {
             // Invalid username or password
             $error = "Your Login Name or Password is invalid";
         

         // Borrowed (stolen) code
         $time=time()-30;
         $ip_address=getIpAddr();

         // Getting total count of hits on the basis of IP
         $query=mysqli_query($conn,"select count(*) as total_count from loginlogs where TryTime > $time and IpAddress='$ip_address'");
         $check_login_row=mysqli_fetch_assoc($query);
         $total_count=$check_login_row['total_count'];

         //Checking if the attempt 3, or youcan set the no of attempt her. For now we taking only 3 fail attempted
         if($total_count==3){
            $msg="To many failed login attempts. Please login after 30 sec";
         }else{

            //Getting Post Values
            $username=$_POST['username'];
            $password=md5($_POST['password']); // change to hash and verify

            // Coding for login
            $res=mysqli_query($conn,"select * from users where username='$username' and password='$password'");

            if(mysqli_num_rows($res)){
               $_SESSION['login_user']='yes';
               mysqli_query($conn,"delete from loginlogs where IpAddress='$ip_address'");
               header('location:index.php');
            }else{
               $total_count++;
               $rem_attm=3-$total_count;
            if($rem_attm==0){
               $msg="To many failed login attempts. Please login after 30 sec";
            }else{
               $msg="Please enter valid login details.<br/>$rem_attm attempts remaining";
            }
               $try_time=time();
               mysqli_query($conn,"insert into loginlogs(IpAddress,TryTime) values('$ip_address','$try_time')");
               }
            }
         }
      }
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

   /*if (!$_SESSION) {
      print_r($_SESSION);
   } else {
      echo "No session";
   }*/

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

   <?php echo $_success_message; ?>
   <div align = "center">
      <div style = "width:300px; border: solid 1px #333333; " align = "left">
         <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
         <div style = "margin:30px">
            <form action = "login.php" method = "post">
               <label>UserName  :</label><input type = "text" name = "username" class = "box" id="loginname"/><br /><br />
               <label>Password  :</label><input type = "password" name = "password" class = "box" id="loginpass"/><br/><br />
               <input type = "submit" value = " Submit "/><br />
            </form>
            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?= $error; ?></div>
            <div id="result"><?= $msg?></div>
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

      function formClear() {
        /*document.getElementById('loginname').value = '';
        document.getElementById('loginpass').value = '';*/
    }

</script>
</body>
</html>