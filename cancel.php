<?php 
include("session.php");

// Register user
if(isset($_POST['btndeleteres'])){
    $success = "";

    // Getting variable from input
    $reservation = trim($_POST['reservation']);

     // Delete venue
    $deleteSQL = 'delete from reservation where reservation_id='.$reservation.';';
    if(mysqli_query($connect, $deleteSQL)){
        $success = "Reservation cancelled.";
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
                    $sql = "select * from reservation where customer_user = '". $user_session ."'";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $events[] = $row["event_name"];
                        $garage_ids[] = $row["garage_id"];
                        $id[] = $row['reservation_id'];
                    }
                    for ($i = 0; $i < sizeof($events); $i++) {
                        echo '<option value="'.$id[$i].'"> For event: ' . $events[$i] . ' in garage number '.$garage_ids[$i].'</option>';
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