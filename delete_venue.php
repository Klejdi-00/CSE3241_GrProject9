<?php 
include("session.php");

// Register user
if(isset($_POST['btndeletevenue'])){
    $success = "";
    $error = "";
    $check_inputs = true;

    // Getting variable from input
    $venue = trim($_POST['venue']);

    if($check_inputs){
      // Check if there's events in venue
      $stmt = $connect->prepare("SELECT * FROM event_list WHERE venue = ?");
      $stmt->bind_param("s", $venue);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      if($result->num_rows > 0){
        $check_inputs = false;
        $error = "There is at least one event in this venue. Events need to be deleted first.";
      }
    }

     // Delete venue
     if ($check_inputs){
      $deleteSQL1 = 'delete from distance where venue="'.$venue.'";';
      mysqli_query($connect, $deleteSQL1);
      $deleteSQL2 = 'delete from event_list where venue="'.$venue.'";';
      mysqli_query($connect, $deleteSQL2);
      $deleteSQL3 = 'delete from venue where venue_name="'.$venue.'";';
      if(mysqli_query($connect, $deleteSQL3)){
          $success = "Venue deleted.";
      }
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Delete Venue | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Delete Venue</h2>
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
                <label for="venue">Select a Venue:</label>
                <select class="form-control" style="text-align:center" name="venue" required>
                    <option selected value="">Choose a Venue</option>
                    <?php
                    // Getting all the venues in an array
                    $venues = array();
                    $sql = "select * from venue";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $venues[] = $row["venue_name"];
                    }
                    foreach($venues as $value){
                        echo '<option>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="btndeletevenue" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="venadmin.php"> Homepage</a></h3>
  </body>
</html>