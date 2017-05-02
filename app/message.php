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
          $currentuser="select user_id from userinfo where email_id='".$_SESSION['EmailID']."';";
        $result1=pg_query($currentuser);
        $userone=pg_fetch_row($result1)[0];
          
//Posts from friends to current user are displayed here 
            echo 'POSTS FROM FRIENDS';
            $query_posts =  "select A.username,posts.content,date(posts.post_time)from userinfo A, posts where A.user_id=posts.poster_id and postee_id='".(int)$userone."' and poster_id <> postee_id order by posts.post_time DESC;"; 
            $result_posts=pg_query($query_posts);
            echo '<p>';
            while($row = pg_fetch_row($result_posts)){
              echo '<button><a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
              echo ' posted to you!';
              echo '<br>';
              echo $row[1]." on ".$row[2]."";
              echo '<br>';
              echo '<br>';
              echo '<a href="upload_post.php">Reply to the posts</button></a>'; 
            }
           
          echo '</p>';
         }   
        ?>
      </p>
    </div>
  </body>
</html>
