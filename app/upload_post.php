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
    <title>ActiveSpace: Post IT</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
    <p align="center">Share a POST with everyone today!</p>
    <form action="upload_post.php" method="post">
    <p align="center"> What's on your mind <br>
    
    <input type="text" class="description" name="description" placeholder=" " />
        
    <p align="center"> To broadcast this post to everyone in your network, hit EVERYONE! else hit Specify Friend<br>
    <input type="radio" name="Association" value="1" checked /> Everyone
    <input type="radio" name="Association" value="2"> Pick a Friend
        
    <select name="pick_friend">
      <?php
       $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
            $result1=pg_query($id);
            $id_op=pg_fetch_row($result1);
            
            $query = "select user_id, username, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                    UNION
                    select user_id, username, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."';";;
            $rs = pg_query($db, $query) or die("Cannot execute query: $query\n"); 
            echo '<option default>Choose a friend from the list...</option>';
            while($row = pg_fetch_row($rs)){
              echo '<option value ='.$row[0].'>'.$row[1].', '.$row[2].' '.$row[3].'</option>';
              }
            echo '</select>';
      ?>
        <br><br>
       <input align="center" type="image" alt="Submit" src="img_submit.png" name="submitbutton" value="Submit" width="45" height="45">
        <br>
      <input alight="center" type="reset">

        </p>
        
      </form>
        
      <?php
         if(isset($_SESSION['EmailID'])&&(isset($_POST['submitbutton']))) {
          $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
          $result1=pg_query($id);
          $id_op=pg_fetch_row($result1);

          // Gets description from POST 
          $description = $_POST['description'];
                        // Gets photo name
          $option = $_POST['Association'];
          $specific_user= $_POST['pick_friend'];

          if($option=='1'){
            $query = "select upload_posts('".$id_op[0]."','".$id_op[0]."','".$description."');";
            $result = pg_query($query);
            echo "<p>Post has been successfully shared with everyone! <br><br> Click on POSTS in navigation bar to check out the latest uploads!</p>";
          }
          if($option=='2'){
            $query = "select upload_posts('".$id_op[0]."','".$specific_user."','".$description."');";
            $result = pg_query($query);
            $userquery= "select username from userinfo where user_id ='".$specific_user."';";
            $result1=pg_query($userquery);
            $userid=pg_fetch_row($result1);
            echo "<p>Post has been successfully shared with <a href=search.php?variable_search=".$userid[0].">".$userid[0]."</a> !! <br><br> Click on POSTS in navigation bar to check out the latest uploads!</P>";
          }

          }   
        ?>
      </p>
    </div>
  </body>
</html>
