<?php 
include("session.php");

// Register user
if(isset($_POST['btnaddevent'])){
    $error = "";
    $success = "";
    $check_inputs = true;

    // Getting variables from input
    $event_name = trim($_POST['event_name']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $venue = trim($_POST['venue']);

     if($check_inputs){
       // Check if event already exists
       $stmt = $connect->prepare("select * from event_list where event_name = ?");
       $stmt->bind_param("s", $event_name);
       $stmt->execute();
       $result = $stmt->get_result();
       $stmt->close();
       if($result->num_rows > 0){
         $check_inputs = false;
         $error = "There exists an event with the same name.";
       }
     }

     // Insert records
     if($check_inputs){
       $insertEventSQL = 'insert into event_list(event_name, start_date, end_date, venue) 
                            values("'.$event_name.'","'.$start_date.'","'.$end_date.'","'.$venue.'");';
       if(mysqli_query($connect, $insertEventSQL)){
            $success = "Event was added.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add Event | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Add Event</h2>
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
              <label for="event_name">Event Name:</label>
              <input style="text-align:center" required type="text" class="form-control" name="event_name" id="event_name" maxlength="80">
            </div>
            <div class="form-group">
              <label for="start_date">Start Date:</label>
              <input style="text-align:center" required type="date" min = "0000-01-01" max = "9999-12-31" class="form-control" name="start_date" id="start_date">
            </div>
            <div class="form-group">
              <label for="end_date">End Date:</label>
              <input style="text-align:center" required type="date" min = "0000-01-01" max = "9999-12-31" class="form-control" name="end_date" id="end_date">
            </div>
            <div class="form-group">
                <label for="venue">Venue:</label>
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
            <button type="submit" name="btnaddevent" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="venadmin.php"> Homepage</a></h3>
  </body>
</html>