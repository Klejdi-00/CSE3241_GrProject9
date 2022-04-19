<?php 
include("session.php");
// Register user
if(isset($_POST['btnevent'])){
    $success = "";
    // Getting variable from input
    $prices = $_POST['prices'];
    $event = $_POST['event'];
    // Getting all the garage_id-s in an array
    $garages = array();
    $tempSQL = "select garage_id from garage";
    $qrry = $connect->query($tempSQL);
    while($row = $qrry->fetch_assoc()) {
       $garages[] = $row["garage_id"];
    }
    // Inserting prices
    if ($prices){
        for ($i = 0; $i < sizeof($prices); $i++){
            $tempSQL = "select event_name from pricing where garage_id =" . $garages[$i];
            $tempqrry = $connect->query($tempSQL);
            $events = array();
            while($row = $tempqrry->fetch_assoc()){
                $events[] = $row['event_name'];
            }
            if (!in_array( $event, $events)){
                $insertPricesSQL = "insert into pricing(event_name,garage_id,price) 
                                        values('" . $event . "',". $garages[$i] . ",".$prices[$i].")";
                if(mysqli_query($connect, $insertPricesSQL)){
                    $success .= "Price was added. ";
                }
            } else {
                $insertPricesSQL = "update pricing set price = ".$prices[$i]." where event_name =\"". $event."\" and garage_id = " . $garages[$i];
                mysqli_query($connect, $insertPricesSQL);
                $success .= "Price was updated. ";
            }
        }
    }
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
          <form method='post' action=''>
          <h2 style="padding-top:25px">Add/Update Prices</h2>
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
                <label for="event">Selected Event:</label>
                <select class="form-control" style="text-align:center" name="event">
                    <option><?php echo $_POST['event'] ?></option>
                </select>
            </div>
            <div class="form-group">
            <?php
                $event = $_POST['event'];
                // Getting variable from input
                $sql1 = "select venue from event_list where event_name = '".$event."';";
                $querry = mysqli_query($connect, $sql1);
                $row = $querry->fetch_assoc();
                $venue = $row["venue"];

                $distances  = array();
                $sqli = 'select distance from distance where venue ="' . $venue . '"';
                $qrry = $connect->query($sqli);
                while($row = $qrry->fetch_assoc()) { 
                    $distances[] = $row['distance'];
                }

                $tempSQL = "select garage_id, name from garage";
                $qrry = $connect->query($tempSQL);
                $i = 0;
                while($row = $qrry->fetch_assoc()) {  
            ?>
            <div class="form-group">
              <label for="prices">Price for <?php echo $row["name"] ?> (Distance: <?php echo $distances[$i] ?> miles):</label>
              <input style="text-align:center" required type="number" step="0.01" class="form-control" name="prices[]" id="prices">
            </div>
            <?php
                    
                    $i++;
                }
            ?>
            </div>
            <button type="submit" name="btnevent" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="venadmin.php"> Homepage</a></h3>
  </body>
</html>