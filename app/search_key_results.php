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
    <title>ActiveSpace: Search</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
        <p>SEARCH RESULTS</p>
         <p>
          <?php
#CHECK searchbutton
    if(isset($_SESSION['EmailID'])){ 
      $input=$_POST['Association']; 
    
      if(empty($_POST['Name'])) {
        echo 'No Name or Association input';
        echo '<br>';
        echo '<br>';
        
        $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
        $result1=pg_query($id);
        $id_op=pg_fetch_row($result1);

      if ($input=="1"){
          $query_posts =  "select A.username,B.username,posts.content,date(posts.post_time)from userinfo A, userinfo B, posts where A.network_visibility IN (1,2,3) and A.user_id=posts.poster_id and B.user_id=postee_id and posts.poster_id in
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
              }
              echo '</p>';
            }

        if ($input=="2"){
          $query_media =  "select userinfo.username,multimedia.content,multimedia.description,date(multimedia.post_time)from userinfo, multimedia where userinfo.network_visibility IN (1,2,3) and userinfo.user_id=multimedia.user_id and multimedia.user_id in
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

          if ($input=="3")
            {
              $query_diary =  "WITH get_location as(select city, state, country, loc_id from location)

                    select D.diary_id,D.title, D.entry, D.multimedia, date(diarytime), L.city, L.state, L.country, U.username from diaryentry D, get_location L, userinfo U where U.network_visibility IN (1,2,3) and D.user_id=U.user_id and L.loc_id=D.loc_id and D.user_id in   (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') order by D.diarytime DESC";
            $result_diary=pg_query($query_diary);
            
            
            if($diary = pg_fetch_row($result_diary)){
                echo '<h1>'.$diary[1].'</h1>';
                echo '<p> by <a href="search.php?variable_search='.$diary[8].'">'. $diary[8].'</a></p>';
                echo '<p> on '. $diary[4].'</p>';
                echo '<p> at '.$diary[5].", ".$diary[6].", ".$diary[7].'</p>';
                echo '<br>';
                echo '<p>';
                echo '<img class= "imageformat" src="uploads/'.$diary[3].'">';
                echo '<br>';
                echo $diary[2];
                echo '</p>';
                
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
                  echo $comments[1];
                  echo '<br>';
                 } 
               }

              echo '<a class="button" href="add_like.php?diary_like='.$diary[0].'"><img src="like_button.png" name="likebutton" value="Submit" width="25" height="25"></button></a>';
               echo '   <a class="button" href="add_dlike.php?diary_dlike='.$diary[0].'"><img src="dlike_button.png" name="dlikebutton" value="Submit" width="35" height="35"></button></a>';
               echo ' Click here to view diary entry LIKE THIS or ADD COMMENT ';
              echo '<a class="button" href="add_comment.php?diary_comment='.$diary[0].'"><img src="comment_button.png" name="commentbutton" value="Submit" width="25" height="25"></button></a>';
              echo '</p>';
             

              }
              echo '</p>';
        echo '<br>';
        echo '<br>';
         }

           if ($input=="4"){
            
            $queryd = "SELECT user_id FROM userinfo WHERE email_id = '".$_SESSION['EmailID']."';";
                $resd = pg_query($queryd) or die("Cannot execute query: $queryd\n");
                $uidd = pg_fetch_row($resd);

                $query = "SELECT * FROM events";
                $result = pg_query($query) or die("Cannot execute query: $query\n");
                while($row = pg_fetch_assoc($result)){
                    echo '<form method = "POST">';
                    echo '<p>';
                    echo '<label>Event Name: '.$row['title'].'</label><br><br>';
                    echo '<label>Event Time: '.$row['event_time'].'</label><br><br>';
                    echo '<label>'.$row['description'].'</label><br><br>';

                    $querym = "SELECT * FROM event_members WHERE event_id = ".$row['event_id'].";";
                    $resultm = pg_query($querym) or die("Cannot execute query: $querym\n");
                    echo '<label>Event Members: ';
                    while($rowm = pg_fetch_assoc($resultm)){
                        $queryu = "SELECT username FROM userinfo WHERE user_id = ".$rowm['user_id'].";";
                        $resultu = pg_query($queryu) or die("Cannot execute query: $queryu\n");
                        if($rowu = pg_fetch_assoc($resultu)){
                            echo '<a href="search.php?variable_search='.$rowu['username'].'">'.$rowu['username'].', </a>';
                        }
                    }
                    echo '--end of list-- . </label><br><br>';

// Checking whether to display RSVP button or Withdraw.
                    $queryc = "SELECT * FROM event_members WHERE event_id = ".$row['event_id']." AND user_id = ".$uidd[0].";";
                    $resultc = pg_query($queryc) or die("Cannot execute query: $queryc\n");
                    if($rowc = pg_fetch_assoc($resultc)){
                        echo '<a href="remove_event.php?event='.$row['event_id'].'">Withdraw</a>';
                    }
                    else{
                        echo '<a href="add_event.php?event='.$row['event_id'].'">Click to RSVP</a>';
                    }

                    echo '</p>';
                    echo '</form>';
        }
      }
      if($input=="5"){
        echo "<p>Please enter a valid City, State or Country in the Search bar </p>";
      }
    }
    

        else{

          $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
        $result1=pg_query($id);
        $id_op=pg_fetch_row($result1);

      if ($input=="1"){
          $query_posts =  "select A.username,B.username,posts.content,date(posts.post_time)from userinfo A, userinfo B, posts where A.network_visibility IN (1,2,3) and A.user_id=posts.poster_id and B.user_id=postee_id and posts.poster_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') and posts.content like '%".$_POST['Name']."%'order by posts.post_time DESC";
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
              }
              echo '</p>';
            }

        if ($input=="2"){
          $query_media =  "select userinfo.username,multimedia.content,multimedia.description,date(multimedia.post_time)from userinfo, multimedia where userinfo.network_visibility IN (1,2,3) and userinfo.user_id=multimedia.user_id and multimedia.user_id in
                      (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') and multimedia.description like '%".$_POST['Name']."%' order by multimedia.post_time DESC";
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

          if ($input=="3")
            {
              $query_diary =  "WITH get_location as(select city, state, country, loc_id from location)

                    select D.diary_id,D.title, D.entry, D.multimedia, date(diarytime), L.city, L.state, L.country, U.username from diaryentry D, get_location L, userinfo U where U.network_visibility IN (1,2,3) and D.user_id=U.user_id and L.loc_id=D.loc_id and D.user_id in   (select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                      UNION
                      select userinfo.user_id from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."') and D.title like '%".$_POST['Name']."%' order by D.diarytime DESC";
            $result_diary=pg_query($query_diary);
            
            
            if($diary = pg_fetch_row($result_diary)){
                echo '<h1>'.$diary[1].'</h1>';
                echo '<p> by <a href="search.php?variable_search='.$diary[8].'">'. $diary[8].'</a></p>';
                echo '<p> on '. $diary[4].'</p>';
                echo '<p> at '.$diary[5].", ".$diary[6].", ".$diary[7].'</p>';
                echo '<br>';
                echo '<p>';
                echo '<img class= "imageformat" src="uploads/'.$diary[3].'">';
                echo '<br>';
                echo $diary[2];
                echo '</p>';
                
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
                 
                  echo $comments[1];
                  echo '<br>';
                 } 
               }

              echo '<a class="button" href="add_like.php?diary_like='.$diary[0].'"><img src="like_button.png" name="likebutton" value="Submit" width="25" height="25"></button></a>';
               echo '   <a class="button" href="add_dlike.php?diary_like='.$diary[0].'"><img src="dlike_button.png" name="dlikebutton" value="Submit" width="35" height="35"></button></a>';
               echo ' Click here to view diary entry LIKE THIS or ADD COMMENT ';
              echo '<a class="button" href="add_comment.php?diary_comment='.$diary[0].'"><img src="comment_button.png" name="commentbutton" value="Submit" width="25" height="25"></button></a>';
              echo '</p>';
             

              }
              echo '</p>';
        echo '<br>';
        echo '<br>';
         }

           if ($input=="4"){
            $queryd = "SELECT user_id FROM userinfo WHERE email_id = '".$_SESSION['EmailID']."';";
                $resd = pg_query($queryd) or die("Cannot execute query: $queryd\n");
                $uidd = pg_fetch_row($resd);

                $query = "SELECT * FROM events where title like '%".$_POST['Name']."%';";
                $result = pg_query($query) or die("Cannot execute query: $query\n");
                while($row = pg_fetch_assoc($result)){
                    echo '<form method = "POST">';
                    echo '<p>';
                    echo '<label>Event Name: '.$row['title'].'</label><br><br>';
                    echo '<label>Event Time: '.$row['event_time'].'</label><br><br>';
                    echo '<label>'.$row['description'].'</label><br><br>';

                    $querym = "SELECT * FROM event_members WHERE event_id = ".$row['event_id'].";";
                    $resultm = pg_query($querym) or die("Cannot execute query: $querym\n");
                    echo '<label>Event Members: ';
                    while($rowm = pg_fetch_assoc($resultm)){
                        $queryu = "SELECT username FROM userinfo WHERE user_id = ".$rowm['user_id'].";";
                        $resultu = pg_query($queryu) or die("Cannot execute query: $queryu\n");
                        if($rowu = pg_fetch_assoc($resultu)){
                            echo '<a href="search.php?variable_search='.$rowu['username'].'">'.$rowu['username'].', </a>';
                        }
                    }
                    echo '--end of list-- . </label><br><br>';

// Checking whether to display RSVP button or Withdraw.
                    $queryc = "SELECT * FROM event_members WHERE event_id = ".$row['event_id']." AND user_id = ".$uidd[0].";";
                    $resultc = pg_query($queryc) or die("Cannot execute query: $queryc\n");
                    if($rowc = pg_fetch_assoc($resultc)){
                        echo '<a href="remove_event.php?event='.$row['event_id'].'">Withdraw</a>';
                    }
                    else{
                        echo '<a href="add_event.php?event='.$row['event_id'].'">Click to RSVP</a>';
                    }

                    echo '</p>';
                    echo '</form>';
                  }
                }

                if ($input=="5"){
                  echo '<h1><br><br> Displaying USERS in this location <br><br></h1>';
                  $query_loc= "select username from userinfo,location where userinfo.loc_id=location.loc_id and location.city like '%".$_POST['Name']."%' or location.state like '%".$_POST['Name']."%'or location.country like '%".$_POST['Name']."%';";
                  $execute=pg_query($query_loc);
                  while($rowc = pg_fetch_row($execute)){
                        echo '<p><a href="search.php?varaible_search='.$rowc[0].'">'.$rowc[0].'</a> lived here/lives here. Hit them up!</p>';
                    }
                    
                   
                    echo '<h1><br><br> Displaying DIARY ENTRIES in this location <br><br></h1>';
                  $query_diary =  "WITH get_location as(select city, state, country, loc_id from location)

select U.username,D.title, D.entry, D.multimedia, date(diarytime), L.city, L.state, L.country from diaryentry D, get_location L, userinfo U where D.user_id=U.user_id and L.loc_id=D.loc_id and L.city like '%".$_POST['Name']."%' or L.state like '%".$_POST['Name']."%'or L.country like '%".$_POST['Name']."%';";
            $result_diary=pg_query($query_diary);
            
            
            while($diary = pg_fetch_row($result_diary)){
                echo '<h1>'.$diary[1].'</h1>';
                echo '<p>'.' on '. $diary[4].'</p>';
                echo '<p>'.' at '.$diary[5].", ".$diary[6].", ".$diary[7].'</p>';
                echo '<p><a href="search.php?varaible_search='.$diary[0].'"> by '.$diary[0].'!</a></p>';
                echo '<br>';
                echo '<p>';
                echo '<img class= "imageformat" src="uploads/'.$diary[3].'">';
                echo '<br>';
                echo $diary[2];
                echo '</p>';
                }
                  
                
                echo '<h1><br><br> Displaying EVENTS in this location <br><br></h1>';
                
              $query_events= "select title,event_time from events,location where events.loc_id=location.loc_id and location.city like '%".$_POST['Name']."%' or location.state like '%".$_POST['Name']."%'or location.country like '%".$_POST['Name']."%';";
                  $execute=pg_query($query_events);
                  if($rowc = pg_fetch_row($execute)){
                        echo '<p>'.$rowc[0]."  at '".$rowc[1].'" event is happening here!</p>';
                    }
                    else{
                      echo '<p>No relevant results</p>';
                    }
                  }
      }} 
  ?>
  </p>   
  </div>
  </div>     
</body>
</html>

