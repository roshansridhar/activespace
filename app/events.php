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
        <p align="center"> EVENTS AROUND US</p>
            <?php 
                $queryd = "SELECT user_id FROM userinfo WHERE email_id = '$_SESSION[EmailID]';";
                $resd = pg_query($queryd) or die("Cannot execute query: $queryd\n");
                $uidd = pg_fetch_row($resd);
                $query = "SELECT * FROM events;";
                $result = pg_query($query) or die("Cannot execute query: $query\n");
                while($row = pg_fetch_assoc($result)){
                    echo '<form method = "POST">';
                    echo '<p>';
                    echo '<label>Event Name: '.$row[title].'</label><br><br>';
                    echo 'Event Time: '.$row[event_time].'</label><br><br>';
                    echo '<label>'.$row[description].'</label><br><br>';

                    $querym = "SELECT * FROM event_members WHERE event_id = ".$row[event_id].";";
                    $resultm = pg_query($querym) or die("Cannot execute query: $querym\n");
                    echo '<label>Event Members: ';
                    while($rowm = pg_fetch_assoc($resultm)){
                        $queryu = "SELECT username FROM userinfo WHERE user_id = ".$rowm[user_id].";";
                        $resultu = pg_query($queryu) or die("Cannot execute query: $queryu\n");
                        if($rowu = pg_fetch_assoc($resultu)){
                            echo '<a href="search.php?variable_search='.$rowu[username].'">'.$rowu[username].', </a>';
                        }
                    }
                    echo '--end of list-- . </label><br><br>';

// Checking whether to display RSVP button or Withdraw.
                    $queryc = "SELECT * FROM event_members WHERE event_id = ".$row[event_id]." AND user_id = ".$uidd[0].";";
                    $resultc = pg_query($queryc) or die("Cannot execute query: $queryc\n");
                    if($rowc = pg_fetch_assoc($resultc)){
                        echo '<a href="remove_event.php?event='.$row[event_id].'">Withdraw</a>';
                    }
                    else{
                        echo '<a href="add_event.php?event='.$row[event_id].'">RSVP</a>';
                    }
                    echo '</p>';
                    echo '</form>';
                }    
            ?>
    </div>
  </body>
</html>
