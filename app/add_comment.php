<?php
  $invalid_search='';
  $input='';
  include('../includes/db_connect.php');  
  
  session_start();
  if(!isset($_SESSION['EmailID'])){
    session_destroy();
    header('Location: '.'login.php');
  }     

  if(isset($_POST['commentbutton'])){
    (int)$diaryid=$_POST['diary_id'];
    (int)$userid=$_POST['user_id'];
        $commentquery="select add_diarycommenters('".$userid."','".$diaryid."','".$_POST['Comment']."');";
        $execute=pg_query($commentquery);
        $comment_success= '<p> Your comment has been added <br> Click on refresh</p>';
        $refresh= '<p><a href="add_comment.php"><button> REFRESH </button></a>';
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
           if(isset($_SESSION['EmailID'])){
              $query= "select user_id from userinfo where email_id='".$_SESSION['EmailID']."';";
              $result=pg_query($query);
              $row = pg_fetch_row($result);
				
				     
				      (int)$user_id=$row[0];

        if($_GET['diary_comment']){
          (int)$diary_id=$_GET['diary_comment'];
          echo '<input type ="image" src="comment_button.png" width="45" height="45">';
        }

        $query_diary =  "WITH get_location as(select city, state, country, loc_id from location)

                    select D.diary_id,D.title, D.entry, D.multimedia, date(diarytime), L.city, L.state, L.country, U.username from diaryentry D, get_location L, userinfo U where D.user_id=U.user_id and L.loc_id=D.loc_id and D.diary_id ='".$diary_id."';";
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
                
                $query_likes= "select count(*) as counter from diary_likes where diary_id='".$diary_id."';";
                $result_likes=pg_query($query_likes);
                $likes=pg_fetch_row($result_likes);
                echo '<p>';

                if((int)$likes[0]>0){
                  echo '<a href="likers.php?liker='.$diary_id.'">'.(int)$likes[0]."</a> users like this post ";
                  }    
              }
                else{
                  echo "Be the first to like this";
                }
           
               
                
                echo '<br>';
                echo '<br>';

                $query_comments= "WITH get_username as
                (select username,user_id from userinfo)

                select G.username, C.comment_entry, date(C.comment_time) from get_username G, diary_comments C where C.diary_id=".(int)$diary_id." and C.user_id=G.user_id;";
                $result_comments=pg_query($query_comments);
               
                if(pg_num_rows($result_comments)>0){
                  while($comments=pg_fetch_row($result_comments)){
                  echo '<a href="search.php?variable_search='.$comments[0].'">'.$comments[0].'</a>';
                  echo " on ".$comments[2]." said ";
                  echo '<br>';
                  echo $comments[1];
                  echo '<br>';
                 } 
               }
      }
           
           ?>
          <form class="comment" action="add_comment.php?diary_comment=<?php echo $diary_id ?>" align="left" method="post">
          <input type="text" class="form-control" name="Comment" align="center" placeholder="Add a Comment in here" />
          <input type="hidden" value="<?php echo $diary_id?>" name="diary_id">
          <input type="hidden" value="<?php echo $user_id?>" name="user_id">
          <button> <input type="image" alt="Submit" src="comment_button.png" name="commentbutton" value="Submit" width="30" height="30"></button>   
          </form>

</body> 
</html>



