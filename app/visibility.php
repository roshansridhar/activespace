<?php
  include('../includes/db_connect.php');  
  
  session_start();
  if(!isset($_SESSION['EmailID'])){
    session_destroy();
    header('Location: '.'login.php');

    $query = "SELECT user_id FROM userinfo WHERE email_id = '$_SESSION[EmailID]';";
    $res = pg_query($query) or die("Cannot execute query: $query\n");
    $uid = pg_fetch_row($res);
    $qwe = 5;
  }
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <title>ActiveSpace: Visibility</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
      <p align="center">View or change your visibility settings</p>
      <?php
        if(isset($_SESSION[EmailID])){
          $query = "SELECT * from friendrelation where user_one_id = $uid or  user_two_id = $uid;";
          $result = pg_query($query);
          $info = pg_fetch_assoc($result);
          
          $info[]
        }
      ?>



    </div>
  </body>
</html>