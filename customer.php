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
      <h1>Welcome <?php echo $user_session; ?></h1> 
      <h2><a href = "log_out.php">Log Out</a></h2>
   </body>
   
</html>