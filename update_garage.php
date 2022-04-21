<?php 
include("session.php");

// Register user
if(isset($_POST['btndeletegarage'])){
    $success = "";
    $error = "";
    // Getting variable from input
    $garage = trim($_POST['garage']);
    $max_spaces = $_POST['max_spaces'];
    $sql = "select garage_id from garage where name = '".$garage."';";
    $querry = mysqli_query($connect, $sql);
    $row = $querry->fetch_assoc();
    $garage_id = $row["garage_id"];

    $stmt = $connect->prepare("SELECT max(spaces_taken) FROM spaces WHERE garage_id = ?");
     $stmt->bind_param("i", $garage_id);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $spaces_taken = $row["max(spaces_taken)"];
    } else {
      $spaces_taken = 0;
    }
    if ($max_spaces >= $spaces_taken) {
      $updateSQL = 'update garage set max_spaces = ' . $max_spaces .' where garage_id="'.$garage_id.'";';
      if(mysqli_query($connect, $updateSQL)){
          $success = "Garage updated.";
      }
    } else {
      $error = "The number of reserved spaces is higher than the new number of spaces.";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Update Garage | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Update Garage</h2>
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
                <label for="garage">Select a Garage:</label>
                <select class="form-control" style="text-align:center" name="garage" required>
                    <option selected value="">Choose a Garage</option>
                    <?php
                    // Getting all the venues in an array
                    $garages = array();
                    $sql = "select * from garage";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $garages[] = $row["name"];
                    }
                    foreach($garages as $value){
                        echo '<option>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
              <label for="max_spaces">New Total Number of Spaces:</label>
              <input style="text-align:center" required type="number" class="form-control" name="max_spaces" id="max_spaces" max=1000000 min=0>
            </div>
            <button type="submit" name="btndeletegarage" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="paradmin.php"> Homepage</a></h3>
  </body>
</html>