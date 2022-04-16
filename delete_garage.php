<?php 
include("session.php");

// Register user
if(isset($_POST['btndeletegarage'])){
    $success = "";

    // Getting variable from input
    $garage = trim($_POST['garage']);
    $sql = "select garage_id from garage where name = '".$garage."';";
    $querry = mysqli_query($connect, $sql);
    $row = $querry->fetch_assoc();
    $garage_id = $row["garage_id"];

     // Delete venue
    $deleteSQL1 = 'delete from distance where garage_id="'.$garage_id.'";';
    mysqli_query($connect, $deleteSQL1);
    $deleteSQL2 = 'delete from reservation where garage_id="'.$garage_id.'";';
    mysqli_query($connect, $deleteSQL2);
    $deleteSQL3 = 'delete from spaces where garage_id="'.$garage_id.'";';
    mysqli_query($connect, $deleteSQL3);
    $deleteSQL4 = 'delete from garage where garage_id="'.$garage_id.'";';
    if(mysqli_query($connect, $deleteSQL4)){
        $success = "Garage deleted.";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Delete Garage | ParkingMaster</title>
    <!-- Bootstrap CSS Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  </head>
  <body style = "background-color:lightblue; text-align:center">
    <h1>ParkingMaster</h1>
    <br>
    <div class='col-md-4' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px">
          <form method='post' action=''>
            <h2 style="padding-top:25px">Delete Garage</h2>
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
                <label for="garage">Select a Garage:</label>
                <select class="form-control" style="text-align:center" name="garage" required>
                    <option selected value="">Choose a Garage</option>
                    <?php
                    // Getting all the venues in an array
                    $garages = array();
                    $sql = "select * from garage";
                    $qrry = $connect->query($sql);
                    while($row = $qrry->fetch_assoc()) {
                        $garages[] = $row["name"];
                    }
                    foreach($garages as $value){
                        echo '<option>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="btndeletegarage" class="btn btn-default">Submit</button>
          </form>
          <br>
    </div>
    <br>
    <h3>Return to <a href="paradmin.php"> Homepage</a></h3>
  </body>
</html>