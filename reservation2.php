<?php 
include("session.php");

// Register user
if(isset($_POST['btnres'])){
    $error = "";
    $success = "";
    $check_inputs = true;

    // Getting variable from input
    $event = $_POST['event'];
    $garage_id = $_POST['garage_id'];
    $date = $_POST['date'];

    $sql = "select * from spaces where garage_id = ".$garage_id." and date = '".$date."'";
    $qrry = $connect->query($sql);
    $row = $qrry->fetch_assoc();
    $sql2 = "select max_spaces from garage where garage_id = ".$garage_id;
    $qrry2 = $connect->query($sql2);
    $row2 = $qrry2->fetch_assoc();
    if($row == NULL){
      $tempsql = "insert into spaces(garage_id, date, spaces_taken) values (".$garage_id.", '".$date."', 1)";
      mysqli_query($connect, $tempsql);
    } elseif ($row['spaces_taken'] == $row2['max_spaces']) {
     $check_inputs = false;
     $error = "There are no spaces available in the selected garage and date.";
    }else {
      $tempsql = "update spaces set spaces_taken = spaces_taken + 1 where garage_id = ".$garage_id." and date = '".$date."'";
      mysqli_query($connect, $tempsql);
    }

    if ($check_inputs){
      $sql3 = "select price from pricing where garage_id = ".$garage_id." and event_name = '".$event."'";
      $qrry3 = $connect->query($sql3);
      $row3 = $qrry3->fetch_assoc();
      $price = $row3['price'];
      $sql4 = "insert into reservation(date, fee, customer_user, event_name, garage_id) values ('".$date."', ".$price.", '".$user_session."', '".$event."', ".$garage_id.")";
      if(mysqli_query($connect, $sql4)){
        $success = "Reservation was successful.";
      }
    }
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
          <form method='post' action=''>
            <h2 style="padding-top:25px">Reservation</h2>
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
                <label for="event">Selected Event:</label>
                <select class="form-control" style="text-align:center" name="event">
                    <option><?php echo $_POST['event'] ?></option>
                </select>
            </div>
            <div class="form-group">
              <?php 
                  $event = $_POST['event'];
                  $sql = "select start_date, end_date from event_list where event_name = '".$event."'";
                  $qrry = $connect->query($sql);
                  $row = $qrry->fetch_assoc();
                  $start = $row['start_date'];
                  $end = $row['end_date'];
              ?>
              <label for="date">Enter a Date:</label>
              <input style="text-align:center" required type="date" min = "<?php echo $start ?>" max = "<?php echo $end ?>" class="form-control" name="date" id="date">
            </div>
            <div class="form-group">
                <label for="garage_id">Select a Garage:</label>
                <select class="form-control" style="text-align:center" name="garage_id" required>
                    <option selected value="">Choose a Garage</option>
                    <?php
                    $garages = array();
                    $ids = array();
                    $distances = array();
                    $prices = array();
                    $sql = "select garage_id, price from pricing where event_name = '".$event."'";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $ids[]= $row["garage_id"];
                        $prices[] = $row['price'];
                    }
                    
                    $sql2 = "select venue from event_list where event_name = '".$event."'";
                    $qrry2 = $connect->query($sql2);
                    $row2 = $qrry2->fetch_assoc();
                    $venue= $row2["venue"];
                    for ($i = 0; $i < sizeof($ids); $i++){
                      $sql3 = "select distance from distance where venue = '".$venue."' and garage_id = ".$ids[$i];
                      $qrry3 = $connect->query($sql3);
                      $row3 = $qrry3->fetch_assoc();
                      $distances[] = $row3['distance'];
                    }

                    for($i = 0; $i < sizeof($ids); $i++) {
                        $sql4 = "select name from garage where garage_id = ".$ids[$i];
                        $qrry4 = $connect->query($sql4);
                        $row4 = $qrry4->fetch_assoc();
                        echo '<option value="'.$ids[$i].'">Name: '. $row4['name']. '  Distance: ' .$distances[$i].' miles  Price: $'.$prices[$i].'</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="btnres" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="customer.php"> Homepage</a></h3>
  </body>
</html>