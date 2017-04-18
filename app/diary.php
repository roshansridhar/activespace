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
        <p align="center"> M   Y       D   I   A   R   Y      E   N   T   R   I   E   S</p>
         <p>
         <?php
          if(isset($_SESSION['EmailID'])){ 
            $query_diary =  "WITH get_location as(select city, state, country, loc_id from location)

select D.diary_id,D.title, D.entry, M.content, date(diarytime), L.city, L.state, L.country from diaryentry D, get_location L,multimedia M, userinfo U where U.email_id='".$_SESSION['EmailID']."' and D.user_id=U.user_id and L.loc_id=D.loc_id and M.media_id=D.media_id;";
            $result_diary=pg_query($query_diary);
            
            
            while($diary = pg_fetch_row($result_diary)){
                echo '<h1>'.$diary[1].'</h1>';
                echo '<p>'.' on '. $diary[4].'</p>';
                echo '<p>'.' at '.$diary[5].", ".$diary[6].", ".$diary[7].'</p>';
                echo '<br>';
                echo '<p>';
                echo $diary[3];
                echo '<br>';
                echo $diary[2];
                echo '</p>';
                
                $query_likes= "WITH get_likes as
                (select count(*) as counter,diary_id from diary_likes group by diary_id)

                select L.counter from get_likes L where L.diary_id='".$diary[0]."';";
                $result_likes=pg_query($query_likes);
                $likes=pg_fetch_row($result_likes);
                echo '<p>';
                if((int)$likes[0]>0){
                  echo (int)$likes[0]." users like this post ";
                }
                else{
                  echo "Be the first to like this ";
                }
                echo '</p>';
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
                 echo '</p>';
               }
             

              }
              echo '</p>';
        echo '<br>';
        echo '<br>';
         }   
        ?>
      </p>
    </div>
  </body>
</html>
