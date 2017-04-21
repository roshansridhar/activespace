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
        <p align="center">Diary Entry Likers</p>
         <p>
         <?php
           if(isset($_SESSION['EmailID'])){
              $query= "select U.username, L.like_time from userinfo U,diary_likes L where U.user_id=L.user_id and L.diary_id='".$_GET['liker']."';";
              $result=pg_query($query);
              while($row = pg_fetch_row($result)){
                echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>'.', ';
              }
              echo " liked the diary entry";

                      
          }
          ?>
      </p>
    </div>
  </body>
</html>