<?php
   include("config.php");
   session_start();
   $usr = $_SESSION['login_user'];
   $session = mysqli_query($connect,"select username from users where username = '$usr'");
   $row = mysqli_fetch_array($session);
   $user_session = $row['username'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
      die();
   }
?>