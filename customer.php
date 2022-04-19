<?php
   include('session.php');
?>
<html">
   
   <head>
      <title>Welcome</title>
      <!-- Bootstrap CSS Stylesheet -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   </head>
   
   <body style = "background-color:lightblue; text-align:center">
      <h1>Welcome, <?php echo $user_session; ?>!</h1> 
      <br>
      <div class='col-md-3' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px" >
         <br>
         <h3><a href="reservation.php">Make a reservation</a></h3>
         <br>
         <br>
         <h3><a href="cancel.php">Cancel a reservation</a></h3>
         <br>
      </div>
      <br>
      <div class='col-md-3' style="float:none; margin:auto; background-color:aliceblue; border-radius:25px" >
         <h2 style="padding:10px"><a href = "log_out.php">Log Out</a></h2>
      </div>
   </body>
   
</html>