<?php
   include('session.php');
?>
<html">
   
   <head>
      <title>Venadmin | ParkingMaster</title>
      <!-- Bootstrap CSS Stylesheet -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   </head>
   
   <body style = "background-color:lightblue; text-align:center">
      <h1>Welcome, Venue Administrator</h1>
      <br>
      <div class='col-md-3' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px" >
         <h3><a href="add_venue.php">Add a venue</a></h3>
      </div>
      <div class='col-md-3' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px" >
         <h3><a href="update_venue.php">Update a venue</a></h3>
      </div>
      <div class='col-md-3' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px" >
         <h3><a href="add_event.php">Add an event</a></h3>
      </div>
      <br>
      <h2><a href = "log_out.php">Log Out</a></h2>
   </body>
   
</html>