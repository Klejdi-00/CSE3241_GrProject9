<?php 
include("config.php");

// Register user
if(isset($_POST['btnsignup'])){
  $error = "";
  $success = "";

   $fname = trim($_POST['fname']);
   $lname = trim($_POST['lname']);
   $phone_nr = trim($_POST['phone_nr']);
   $username = trim($_POST['username']);
   $password = trim($_POST['password']);
   $confirmpassword = trim($_POST['confirmpassword']);

   $check_inputs = true;

   // Check fields are empty or not
   if($fname == '' || $lname == '' || $username == '' || $password == '' || $confirmpassword == '' || $phone_nr == ''){
     $check_inputs = false;
     $error = "Fill all fields.";
   }

   // Check if password is at least 8 characters
   if($check_inputs && strlen($password) < 8){
    $check_inputs = false;
    $error = "Password is less than 8 characters.";
  }

   // Check if confirm password matching or not
   if($check_inputs && ($password != $confirmpassword) ){
     $check_inputs = false;
     $error = "Passwords do not match.";
   }

   // Check if phone number is valid or not
   if ($check_inputs && !preg_match('/^[0-9]{10}+$/', $phone_nr)) {
     $check_inputs = false;
     $error = "Invalid phone number.";
   }

   if($check_inputs){

     // Check if username already exists
     $stmt = $connect->prepare("SELECT * FROM users WHERE username = ?");
     $stmt->bind_param("s", $username);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
     if($result->num_rows > 0){
       $check_inputs = false;
       $error = "Username is taken.";
     }

   }

   // Insert records
   if($check_inputs){
     $insertSQL = "insert into users(fname,lname,username,password,phone_nr) values(?,?,?,?,?)";
     $stmt = $connect->prepare($insertSQL);
     $stmt->bind_param("sssss",$fname,$lname,$username,$password,$phone_nr);
     $stmt->execute();
     $stmt->close();

     $success = "Account was created.";
   }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Register | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Sign Up</h2>
            <br>
            <?php 
            // Display Error message
            if(!empty($error)){
            ?>
            <div class="alert alert-danger">
              <strong>Error:</strong> <?= $error ?>
            </div>

            <?php
            }
            ?>

            <?php 
            // Display Success message
            if(!empty($success)){
            ?>
            <div class="alert alert-success">
              <strong>Success:</strong> <?= $success ?>
            </div>

            <?php
            }
            ?>

            <div class="form-group">
              <label for="fname">First Name:</label>
              <input type="text" class="form-control" name="fname" id="fname" maxlength="80">
            </div>
            <div class="form-group">
              <label for="lname">Last Name:</label>
              <input type="text" class="form-control" name="lname" id="lname" maxlength="80">
            </div>
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="username" class="form-control" name="username" id="username" maxlength="80">
            </div>
            <div class="form-group">
              <label for="phone_nr">Phone # (ex. 1234567890):</label>
              <input type="phone_nr" class="form-control" name="phone_nr" id="phone_nr" maxlength="10">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" id="password" maxlength="80">
            </div>
            <div class="form-group">
              <label for="pwd">Confirm Password:</label>
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" onkeyup='' maxlength="80">
            </div>

            <button type="submit" name="btnsignup" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <h3>Already have an account? Log in <a href="index.php"> here</a>.</h3>
  </body>
</html>