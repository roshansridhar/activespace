<?php
  $invalid_search='';
  $input='';
  include('../includes/db_connect.php');  
  
  session_start();
  $query="Update userinfo set last_log_in=current_timestamp where email_id='".$_SESSION['EmailID']."';";
  $execute=pg_query($query);

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
        <p align="center">L    I    V    E    F    E    E    D</p>
         <p>
         <?php
           if(isset($_SESSION['EmailID'])){

              $query= "select username, picture_medium from userinfo where email_id='".$_SESSION['EmailID']."';";
              $result=pg_query($query);
              if($row = pg_fetch_row($result)){
                echo'<p align="center">';
                if($row[1]==NULL){
                  echo 'We see you still dont have any display picture! Click upload to get started!<br><a href=upload_dp.php><button>UPLOAD</button></a><br><br>';
                }
                else{
                   echo '<img class="imageformat" src="uploads/'.$row[1].'" align="center" width="250" height="250"><br>';
                }
                
                echo '<br>'.$row[0].'! Its good to see you up and running! <br><br>';
                echo 'Click on either of the buttons below to share a POST or DIARY ENTRY or PICTURE about your latest ventures<br>';
                 echo '<p align="center">';
                echo '<a href="upload_post.php"><button>**   POST IT!   **</button></a> ';
                echo '<a href="upload_diary.php"><button>**   DIARY IT!   **</button></a>';
                echo '<a href="upload_photo.php"><button>**   SNAP IT!    **</button></a>';
                echo '</p>';
                echo '<br><br><br><<h2> Below you will find updates from your network. Come, lets activate the space! </h2><br><br><br>';
               
              }

              $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
              $result1=pg_query($id);
              $id_op=pg_fetch_row($result1);
              echo '<br>';

              echo '<div class="postbox">';
            
              echo '<p>D   I   A   R   Y</p>';
              echo '<br>';
             $query_diary =  "WITH get_location as(select city, state, country, loc_id from location)

                    select D.diary_id,D.title, D.entry, D.multimedia, date(diarytime), L.city, L.state, L.country, U.username from diaryentry D, get_location L, userinfo U where D.user_id=U.user_id and L.loc_id=D.loc_id and D.user_id in   (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') and U.visbility > 1 order by D.diarytime DESC";
            $result_diary=pg_query($query_diary);
            
     
            
            if($diary = pg_fetch_row($result_diary)){

                echo '<h1>'.$diary[1].'</h1>';
                echo '<p> by <a href="search.php?variable_search='.$diary[8].'">'. $diary[8].'</a>';
                echo ' on '. $diary[4].' ';
                echo ' at '.$diary[5].", ".$diary[6].", ".$diary[7].'';
                echo '<br>';
                echo '<img class= "imageformat" src="uploads/'.$diary[3].'">';
                echo '<br>';
                echo $diary[2];
           
                $query_likes= "WITH get_likes as
                (select count(*) as counter,diary_id from diary_likes group by diary_id)

                select L.counter,L.diary_id from get_likes L where L.diary_id='".$diary[0]."';";
                $result_likes=pg_query($query_likes);
                (int)$likes=pg_fetch_row($result_likes);
                echo '<p>';
                if((int)$likes[0]>0){
                  echo '<a href="likers.php?liker='.$likes[1].'">'.(int)$likes[0]."</a> users like this post ";
                }
                else{
                  echo "Give this a thumbs up!!";
                }
                echo '<br>';
                echo '<br>';

                $query_dlikes= "WITH get_dlikes as
                (select count(*) as counter,diary_id from diary_dlikes group by diary_id)

                select L.counter,L.diary_id from get_dlikes L where L.diary_id='".$diary[0]."';";
                $result_dlikes=pg_query($query_dlikes);
                (int)$dlikes=pg_fetch_row($result_dlikes);
                echo '<p>';
                if((int)$dlikes[0]>0){
                  echo '<a href="dlikers.php?dliker='.$dlikes[1].'">'.(int)$dlikes[0]."</a> users dislike this post ";
                }
                else{
                  echo "Give this a thumbs down!!";
                }
                echo '<br>';
                echo '<br>';

                $query_comments= "WITH get_username as
                (select username,user_id from userinfo)

                select G.username, C.comment_entry, date(C.comment_time) from get_username G, diary_comments C where C.diary_id=".(int)$diary[0]." and C.user_id=G.user_id;";
                $result_comments=pg_query($query_comments);
               
                if(pg_num_rows($result_comments)>0){
                  echo '<p>';
                  while($comments=pg_fetch_row($result_comments)){
                  echo '<a href="search.php?variable_search='.$comments[0].'">'.$comments[0].'</a>';
                  echo " on ".$comments[2]." said ";
                  echo '<br>';
                  echo $comments[1];
                  echo '<br>';
                 } 
               }
              echo '<br><br>';
              echo '<a class="button" href="add_like.php?diary_like='.$diary[0].'"><img src="like_button.png" name="likebutton" value="Submit" width="35" height="35"></button></a>';
              echo '   <a class="button" href="add_dlike.php?diary_dlike='.$diary[0].'"><img src="dlike_button.png" name="dlikebutton" value="Submit" width="35" height="35"></button></a>';
              echo ' Click here to view diary entry LIKE / DISLIKE or ADD COMMENT ';
              echo '<a class="button" href="add_comment.php?diary_comment='.$diary[0].'"><img src="comment_button.png" name="commentbutton" value="Submit" width="35" height="35"></button></a>';
              echo '</p>';
             

              }

            
        echo '<br>';
        echo '<br>';
         
              
              echo '<p>P   O   S   T   S</p>';
              echo '<br>';

              $query_posts =  "select A.username,B.username,posts.content,date(posts.post_time)from userinfo A, userinfo B, posts where A.visbility>1 and A.user_id=posts.poster_id and B.user_id=postee_id and posts.poster_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') order by posts.post_time DESC";
              $result_posts=pg_query($query_posts);
              
              echo '<p>';
              while($row = pg_fetch_row($result_posts)){
                if($row[0]==$row[1]){
                echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
                echo ' posted to Everyone';
                echo '<br>';
                echo $row[2]." ".$row[3]."";
                echo '<br>';
                echo '<br>';
              }
                else{
                echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
                echo ' posted to ';
                echo '<a href="search.php?variable_search='.$row[1].'">'.$row[1].'</a>';
                echo '<br>';
                echo $row[2]." ".$row[3]."";
                echo '<br>';
                echo '<br>';
                }
              }
              echo '</p>';


              echo '<br>';
              echo '<p>M   E   D   I   A</p>';
              echo '<br>';

              $query_media =  "select userinfo.username,multimedia.content,multimedia.description,date(multimedia.post_time)from userinfo, multimedia where userinfo.visbility>1 and userinfo.user_id=multimedia.user_id and multimedia.user_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') order by multimedia.post_time DESC";
              $result_media=pg_query($query_media);
              
              echo '<p>';
              while($row = pg_fetch_row($result_media)){
                echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
                echo '<br>';
                echo '<img class= "imageformat" src="uploads/'.$row[1].'">';
                echo $row[2]." ".$row[3];
                echo '<br>'; 
                echo '<br>';
              }
              echo '</p>';
          }   
        ?>
      </p>
    </div>
  </body>
</html>
