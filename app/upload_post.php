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
        <div class="container">
        <p align="center">Share a POST with everyone today!</p>
        <form action="upload_diary.php" method="post" enctype="multipart/form-data">
        <br>
        <p align="center"> What's on your mind <br>
        <input type="text" class="description" name="title" placeholder=" " />
        
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
         if(isset($_SESSION['EmailID'])){

          }   
        ?>
      </p>
    </div>
  </body>
</html>
