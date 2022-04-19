<?php 
include("session.php");

// Register user
if(isset($_POST['btnevent'])){
    // Getting variable from input
    $event = trim($_POST['event']);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add Prices | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action='add_prices2.php'>
            <h2 style="padding-top:25px">Add Prices</h2>
            <br>
            <div class="form-group">
                <label for="event">Select an Event:</label>
                <select class="form-control" style="text-align:center" name="event" required>
                    <option selected value="">Choose an Event</option>
                    <?php
                    // Getting all the venues in an array
                    $events = array();
                    $sql = "select event_name from event_list";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $events[] = $row["event_name"];
                    }
                    foreach($events as $event){
                        echo '<option>' . $event . '</option>';
                    }
                    ?>
                </select><br>
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="venadmin.php"> Homepage</a></h3>
  </body>
</html>