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
      <p align="center"> INBOX </p>
      <p>
      <?php
        if(isset($_SESSION['EmailID'])){
          $query= "select username from userinfo where email_id='".$_SESSION['EmailID']."';";
          $result=pg_query($query);
          if($row = pg_fetch_row($result)){
            echo $row[0].'! ActiveSpace Messages :';
          }
            
         echo '<br>';

// obtain the userid
        $currentuser="select user_id from userinfo where email_id='".$_SESSION['EmailID']."';";
        $result1=pg_query($currentuser);
        $userone=pg_fetch_row($result1)[0];

// obtain all the userids from user table to check if new friend requests have been sent or accepted
        $profileuser="select user_id from userinfo;";
        $result2=pg_query($profileuser);
              
        echo '<p><br> FRIEND REQUESTS <br><br>';

// Displays the previously accepted friend requests with timestamps and pending request 
        while($usertwo=pg_fetch_row($result2)){
          $friendstat="select action_user_id from friendrelation where 
              friendship_status='1' and user_one_id IN (".(int)$userone.",".(int)$usertwo[0].") and user_two_id IN (".(int)$userone.",".(int)$usertwo[0].");";
          $result=pg_query($friendstat);
          $row= pg_fetch_row($result);

//Friend requests
          if(pg_num_rows($result)>0){
            if($row[0]==(int)$usertwo[0]){
              echo "<p> ";
              $query= "select username,picture_medium from userinfo where user_id='".(int)$row[0]."';";
              $result=pg_query($query);
              $user_msg = pg_fetch_row($result);
              echo '<a href="search.php?variable_search='.$user_msg[0].'">'.$user_msg[0]."</a> has sent you a request to connect.";
              echo '<br><a href="accept.php?request='.(int)$row[0].'"><button>   ACCEPT INVITE </button></a>';
              echo '<a href="decline.php?request='.(int)$row[0].'"><button>    DECLINE INVITE </button></a>';
              echo '<br>';
              echo '</p>';
              }
          }

            
          $friendstat="select action_user_id,action_taken_time from friendrelation where 
              friendship_status='2' and user_one_id IN (".(int)$userone.",".(int)$usertwo[0].") and user_two_id IN (".(int)$userone.",".(int)$usertwo[0].");";
          $result=pg_query($friendstat);
          $row= pg_fetch_row($result);

//Accepted friend requests
          if(pg_num_rows($result)>0){
            if($row[0]==(int)$userone[0]){
              echo "<p> ";
              
              $query= "select username,picture_medium from userinfo where user_id='".$usertwo[0]."';";
              $result=pg_query($query);
              $user_msg = pg_fetch_row($result);
              echo '<a href="search.php?variable_search='.$user_msg[0].'">'.$user_msg[0]."</a> has accepted your request to connect on ".$row[1]." !!";
              echo '<br>';
              echo '</p>';
            }
          }
        }

//Posts from friends to current user are displayed here 
            echo '<p><br><br> POSTS FROM FRIENDS <br><br>';
            $query_posts =  "select A.username,posts.content,date(posts.post_time)from userinfo A, posts where A.user_id=posts.poster_id and postee_id='".(int)$userone."' order by posts.post_time DESC;"; 
            $result_posts=pg_query($query_posts);
            echo '<p>';
            while($row = pg_fetch_row($result_posts)){
              echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
              echo ' posted the following to you!';
              echo '<br>';
              echo $row[1]." on ".$row[2]."";
              echo '<br>';
              echo '<br>';
            }
           echo '</p> <a href="posts.php><button>Reply to the posts<button></a>'; 
          
         }   
        ?>
      </p>
    </div>
  </body>
</html>
