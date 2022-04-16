<?php
   include("config.php");

   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $user = mysqli_real_escape_string($connect,$_POST['username']);
      $pass = mysqli_real_escape_string($connect,$_POST['password']); 
      
      $sql = "select * from users where username = '$user' and password = '$pass'";
      $querry = mysqli_query($connect,$sql);
		
      if(mysqli_num_rows($querry) == 1) {
         $_SESSION['login_user'] = $user;
         if (strtoupper($user) == "VENADMIN"){
            header("location: venadmin.php");
         } elseif (strtoupper($user) == "PARADMIN") {
            header("location: paradmin.php");
         } else {
            header("location: customer.php");
         }
      } else {
         $_SESSION['message'] = "Username or Password is Invalid!";
      }
   }
?>
<html>
   
   <head>
      <title>Login | ParkingMaster</title>
      <!-- Bootstrap CSS Stylesheet -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   </head>
   
   <body style = "background-color:lightblue; text-align:center">
      <h1>ParkingMaster</h1>
      <br>
      <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px" >
               <form method='post' action=''>
                  <h2 style="padding-top:20px">Log In</h2>
                  <br>
                  <?php 
                  // Display Error message
                  if (isset($_SESSION['message'])) {
                  ?>
                     <div class="alert alert-danger">
                        <strong>Error:</strong> <?= $_SESSION['message'] ?>
                     </div>
                  <?php
                     unset($_SESSION['message']);
                  }
                  ?>
                  <div class="form-group">
                     <label for="username">Username:</label>
                     <input style="text-align:center" type="text" class="form-control" name="username" id="username" required="required" maxlength="80">
                  </div>
                  <div class="form-group">
                     <label for="password">Password:</label>
                     <input style="text-align:center" type="password" class="form-control" name="password" id="password" required="required" maxlength="80">
                  </div>
                  <button type="submit" name="btnsignup" class="btn btn-default">LOG IN</button>
               </form>
               <br>
      </div>
      <h3>Don't have an account? Register <a href="registration.php"> here</a>.</h3>
   </body>
</html>