<?php 
include("session.php");

// Register user
if(isset($_POST['btnaddvenue'])){
    $error = "";
    $success = "";
    $check_inputs = true;

    // Getting venue_name from input
     $venue_name = trim($_POST['venue_name']);

     // Getting the distances from input
     $distances = $_POST['distances'];

     // Getting all the garage_id-s in an array
     $garages = array();
     $tempSQL = "select garage_id from garage";
    $qrry = $connect->query($tempSQL);
    while($row = $qrry->fetch_assoc()) {
        $garages[] = $row["garage_id"];
    }

     if($check_inputs){
       // Check if venue already exists
       $stmt = $connect->prepare("select * from venue where venue_name = ?");
       $stmt->bind_param("s", $venue_name);
       $stmt->execute();
       $result = $stmt->get_result();
       $stmt->close();
       if($result->num_rows > 0){
         $check_inputs = false;
         $error = "There exists a venue with the same name.";
       }
     }
  
     // Insert records
     if($check_inputs){
        // Inserting venue_name to venue
       $insertVenueSQL = "insert into venue(venue_name) values(?)";
       $stmt = $connect->prepare($insertVenueSQL);
       $stmt->bind_param("s",$venue_name);
       $stmt->execute();
       $stmt->close();

       // Inserting distances
        for ($i = 0; $i < sizeof($distances); $i++){
            $insertDistancesSQL = "insert into distance(garage_id,venue,distance) 
                                    values(" . $garages[$i] . ',"' . $venue_name . '",' . $distances[$i] . ');';
            if(mysqli_query($connect, $insertDistancesSQL)){
                $success = "Distances were added. ";
            }
        }
        $success .= "Venue was added.";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add Venue | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Add a Venue</h2>
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
              <label for="venue_name">Venue Name:</label>
              <input required type="text" class="form-control" name="venue_name" id="venue_name" maxlength="80">
            </div>
            <?php
                $tempSQL = "select name from garage";
                $qrry = $connect->query($tempSQL);
                while($row = $qrry->fetch_assoc()) {   
            ?>
            <div class="form-group">
              <label for="distances">Distance from <?php echo $row["name"] ?> (miles):</label>
              <input required type="number" step="0.01" class="form-control" name="distances[]" id="distances">
            </div>
            <?php
                }
            ?>
            <button type="submit" name="btnaddvenue" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <h3>Return to <a href="venadmin.php"> Homepage</a></h3>
  </body>
</html>