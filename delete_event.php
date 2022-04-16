<?php 
include("session.php");

// Register user
if(isset($_POST['btndeleteevent'])){
    $success = "";

    // Getting variable from input
    $event = trim($_POST['event']);

     // Delete venue
    $deleteSQL1 = 'delete from reservation where event_name="'.$event.'";';
    mysqli_query($connect, $deleteSQL1);
    $deleteSQL2 = 'delete from event where event_name="'.$event.'";';
    if(mysqli_query($connect, $deleteSQL2)){
        $success = "Event deleted.";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Delete Event | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Delete Event</h2>
            <br>
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
                <label for="event">Select an Event:</label>
                <select class="form-control" style="text-align:center" name="event" required>
                    <option selected value="">Choose an Event</option>
                    <?php
                    // Getting all the venues in an array
                    $events = array();
                    $sql = "select event_name from event";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $events[] = $row["event_name"];
                    }
                    foreach($events as $event){
                        echo '<option>' . $event . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="btndeleteevent" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="venadmin.php"> Homepage</a></h3>
  </body>
</html>