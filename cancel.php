<?php 
include("session.php");

// Register user
if(isset($_POST['btndeleteres'])){
    $success = "";

    // Getting variable from input
    $reservation = trim($_POST['reservation']);
    $curr_date = date('Y-m-d');
    $date1 = new DateTime($curr_date);

    $tempsql1 = "select date, garage_id from reservation where reservation_id = ". $reservation;
    $q = mysqli_query($connect, $tempsql1);
    $row = $q->fetch_assoc();
    $garage_id = $row['garage_id'];
    $date = $row['date'];
    $date2 = new DateTime($date);
    $diff = abs(strtotime($date) - strtotime($curr_date));
    if ($diff < 3){
      $tempsql2 = "update spaces set spaces_taken = spaces_taken - 1 where garage_id = ".$garage_id." and date = '".$date."'";
      mysqli_query($connect, $tempsql2);
      // Delete venue
      $deleteSQL = 'delete from reservation where reservation_id='.$reservation.';';
      if(mysqli_query($connect, $deleteSQL)){
          $success = "Reservation cancelled.";
      }
    } else {
      $error = "Reservation can not be cancelled less than 3 days prior to event.";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Cancel Reservation | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Cancel Reservation</h2>
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
                <label for="reservation">Select a Reservation:</label>
                <select class="form-control" style="text-align:center" name="reservation" required>
                    <option selected value="">Choose a Reservation</option>
                    <?php
                    // Getting all the venues in an array
                    $events = array();
                    $garage_ids = array();
                    $id = array();
                    $date = array();
                    $sql = "select * from reservation where customer_user = '". $user_session ."'";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $events[] = $row["event_name"];
                        $garage_ids[] = $row["garage_id"];
                        $id[] = $row['reservation_id'];
                        $date[] = $row['date'];
                    }
                    for ($i = 0; $i < sizeof($events); $i++) {
                        $sql = "select name from garage where garage_id = '". $garage_ids[$i] ."'";
                        $qrry = $connect->query($sql);
                        $row = $qrry->fetch_assoc();
                        echo '<option value="'.$id[$i].'"> For event: ' . $events[$i] . ' in garage '.$row['name'].' on '.$date[$i].'</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="btndeleteres" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="customer.php"> Homepage</a></h3>
  </body>
</html>