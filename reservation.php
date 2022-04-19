<?php 
include("session.php");

// Register user
if(isset($_POST['btnres'])){
    // Getting variable from input
    $event = trim($_POST['event']);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Reservation | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action='reservation2.php'>
            <h2 style="padding-top:25px">Reservation</h2>
            <br>
            <div class="form-group">
                <label for="event">Select an Event:</label>
                <select class="form-control" style="text-align:center" name="event" required>
                    <option selected value="">Choose an Event</option>
                    <?php
                    // Getting all the venues in an array
                    $events = array();
                    $start = array();
                    $end = array();
                    $venues = array();
                    $sql = "select * from event_list";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $events[] = $row["event_name"];
                        $start[] = $row["start_date"];
                        $end[] = $row["end_date"];
                        $venues[] = $row["venue"];
                    }
                    for($i = 0; $i < sizeof($events); $i++) {
                        echo '<option value="'.$events[$i].'">'. $events[$i]. ' at ' .$venues[$i].' ('.$start[$i].' to '.$end[$i].')</option>';
                    }
                    ?>
                </select>
                <br>
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="customer.php"> Homepage</a></h3>
  </body>
</html>