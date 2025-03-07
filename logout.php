<?php
   session_start();

   session_destroy();
   if(!isset($_SESSION['username'])){
      $loginMessage = 'You have been logged out.';
      include 'index.php';
      exit();
  }
   
   if(session_destroy()) {
      header("Location: login.php");
   }