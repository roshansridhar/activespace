<?php
  $invalid_search='';
  $input='';
  include('../includes/db_connect.php');  
  
  session_start();
  if(!isset($_SESSION['EmailID'])){
    session_destroy();
    header('Location: '.'login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <title>ActiveSpace: Homepage</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
         <p>
         <?php
         $queryd = "SELECT user_id FROM userinfo WHERE email_id = '$_SESSION[EmailID]';";
            $resd = pg_query($queryd) or die("Cannot execute query: $queryd\n");
            $uidd = pg_fetch_row($resd);
        if($_GET['event']){
          (int)$event_id=$_GET['event'];
          $querys = "DELETE FROM event_members WHERE event_id = ".$event_id." AND user_id = ".$uidd[0].";";
          $results = pg_query($querys) or die("Cannot execute query: $querys\n");
          echo "You are now NOT going to the event. ";
          echo '<a href="events.php"><button align="center">Go back</button></a>';
        }
        ?>
      </p>
    </div>
  </body>
</html>