<?php
   include 'dbconnection.php';
   session_destroy();

   // Clear cookies
   setcookie('username', '', time() - 3600, "/");
   setcookie('token', '', time() - 3600, "/");

   if(!isset($_SESSION['username'])){
      $loginMessage = 'You have been logged out.';
      include 'index.php';
      exit();
  }
   
   if(session_destroy()) {
      header("Location: login.php");
   }