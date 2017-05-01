<?php
  $invalid_search='';
  $input='';
  (int)$count= '0';
  include('../includes/db_connect.php');  
  
  session_start();
  if(!isset($_SESSION['EmailID'])){
    session_destroy();
    header('Location: '.'login.php');
  }
?>
<!-- Inbox located at the top right corner displays friend requests and incoming posts from friends -->

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
      <p align="center"> NOTIFICATIONS </p>
      <p>
      <?php
        if(isset($_SESSION['EmailID'])){
          $query= "select username from userinfo where email_id='".$_SESSION['EmailID']."';";
          $result=pg_query($query);
          if($row = pg_fetch_row($result)){
            echo $row[0].'! ActiveSpace Notifications :';
          }
            
         echo '<br>';

// obtain the userid
        $currentuser="select user_id from userinfo where email_id='".$_SESSION['EmailID']."';";
        $result1=pg_query($currentuser);
        $userone=pg_fetch_row($result1)[0];
              
        echo '<p><br> PENDING FRIEND REQUESTS <br><br>';

// Displays the previously accepted friend requests with timestamps and pending request 
        
          $friendstat="With friends as (select * from friendrelation where friendship_status=1 and action_user_id <> ".(int)$userone.")

select count(*) from friends where user_one_id  = ".(int)$userone." or user_two_id =".(int)$userone.";";
          $result=pg_query($friendstat);
          $row= pg_fetch_row($result);

//Friend requests
          if(pg_num_rows($result)>0){            
              echo (int)$row[0].' pending Friend requests';
              echo '<br>';
              echo '<button><a href= "friendstats.php"> Pending Requests </a></button>';
              }
          

          echo '<p><br> ACCEPTED FRIEND REQUESTS (sent by you) <br><br>';

          $friendstat2="With friends as (select * from friendrelation where friendship_status=2 and action_user_id = ".(int)$userone.")

select count(*) from friends;";
          $result2=pg_query($friendstat2);
          $row= pg_fetch_row($result2);

          if(pg_num_rows($result2)>0){            
              echo (int)$row[0].' accepted Friend requests';
              echo '<br>';
              echo '<button><a href= "friendstats.php"> Accepted Requests </a></button>';
              }
          

          echo '<p><br> POSTS RECEIVED  <br><br>';

          $query_posts =  "select count(*) from posts where postee_id=".(int)$userone." and poster_id <> ".(int)$userone.";"; 
          $result3=pg_query($query_posts);
          $row3= pg_fetch_row($result3);
          echo 'You have '.(int)$row3[0].' posts in your inbox. Click here to check them out and reply';
          echo '<button><a href= "message.php"> Posts Messages </a></button>';

            }
        ?>
      </p>
    </div>
  </body>
</html>
