<?php
  $Invalid_search='';
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
    <title>ActiveSpace: HomePage</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>
<body>
    <?php include('../includes/navbar.php'); ?>
        
        <p align="center">L   I   V   E   F   E   E   D</p><p>
          <?php
           if(isset($_SESSION['EmailID'])){
              $query= "select username from userinfo where email_id='".$_SESSION['EmailID']."';";
              $result=pg_query($query);
              if($row = pg_fetch_row($result)){
                echo $row[0].'! What is up today? Updates from your network :';
              }
            echo '<br>';
            $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
            $result1=pg_query($id);
            $id_op=pg_fetch_row($result1);
            echo '<br>';
            echo '<p>D   I   A   R   Y</p>';
            echo '<br>';
            $query_diary =  "select userinfo.username,diaryentry.entry,diaryentry.media_id,date(diaryentry.diarytime) from userinfo, diaryentry where userinfo.user_id=diaryentry.user_id and diaryentry.user_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') order by diaryentry.diarytime DESC";
            $result_diary=pg_query($query_diary);
            echo '<p>';
            while($row = pg_fetch_row($result_diary)){
            echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
            echo '<br>';
            echo $row[1]." ".$row[2]." ".$row[3];
            echo '<br>';
            echo '<br>';
          }echo '</p>';

            echo '<br>';
            echo '<p>P   O   S   T   S</p>';
            echo '<br>';

            $query_posts =  "select A.username,B.username,posts.content,date(posts.post_time)from userinfo A, userinfo B, posts where A.user_id=posts.poster_id and B.user_id=postee_id and posts.poster_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') order by posts.post_time DESC";
            $result_posts=pg_query($query_posts);
            echo '<p>';
            while($row = pg_fetch_row($result_posts)){
            echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
            echo ' posted to ';
            echo '<a href="search.php?variable_search='.$row[1].'">'.$row[1].'</a>';
            echo '<br>';
            echo $row[2]." ".$row[3]."";
            echo '<br>';
            echo '<br>';
          }echo '</p>';


          echo '<br>';
          echo '<p>M   E   D   I   A</p>';
          echo '<br>';

          $query_media =  "select userinfo.username,multimedia.content,multimedia.description,date(multimedia.post_time)from userinfo, multimedia where userinfo.user_id=multimedia.user_id and multimedia.user_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') order by multimedia.post_time DESC";
            $result_media=pg_query($query_media);
            echo '<p>';
            while($row = pg_fetch_row($result_media)){
            echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
            echo '<br>';
            echo $row[1]." ".$row[2]." ".$row[3];
            echo '<br>'; 
            echo '<br>';
          }
          echo '</p>';
        }
            
         ?>
       </p>
        </div>

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 8c4ba5d5e507a2d0e3b24eaf0789a2bba4d12de4
