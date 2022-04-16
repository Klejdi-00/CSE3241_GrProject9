<?php 
include("session.php");

// Register user
if(isset($_POST['btnaddgarage'])){
    $error = "";
    $success = "";
    $check_inputs = true;

    // Getting variables from input
    $garage_name = trim($_POST['garage_name']);
    $address = trim($_POST['address']);
    $max_spaces = $_POST['max_spaces'];

     if($check_inputs){
       // Check if address already exists
       $stmt = $connect->prepare("select * from garage where address = ?");
       $stmt->bind_param("s", $address);
       $stmt->execute();
       $result = $stmt->get_result();
       $stmt->close();
       if($result->num_rows > 0){
         $check_inputs = false;
         $error = "There exists a garage with the same address.";
       }
     }

     // Insert records
     if($check_inputs){
       $insertEventSQL = 'insert into garage(name, address, max_spaces) 
                            values("'.$garage_name.'","'.$address.'",'.$max_spaces.');';
       if(mysqli_query($connect, $insertEventSQL)){
            $success = "Garage was added.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add Garage | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Add Garage</h2>
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
              <label for="garage_name">Garage Name:</label>
              <input style="text-align:center" required type="text" class="form-control" name="garage_name" id="garage_name" maxlength="80">
            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <input style="text-align:center" required type="text" class="form-control" name="address" id="address">
            </div>
            <div class="form-group">
              <label for="max_spaces">Total Number of Spaces:</label>
              <input style="text-align:center" required type="number" class="form-control" name="max_spaces" id="max_spaces">
            </div>
            <button type="submit" name="btnaddgarage" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="paradmin.php"> Homepage</a></h3>
  </body>
</html>