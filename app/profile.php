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
        <p align="center"> M   Y      P   R   O   F   I   L   E</p>
         <p>
         <?php
          if(isset($_SESSION['EmailID'])){ 
            $extract="select username,picture_medium,first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where email_id='".$_SESSION['EmailID']."';" ;
          $finalresult=pg_query($extract);
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo 'PROFILE PICTURE :'.$info[1].'<br><br>';
           echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
          }   
        ?>
      </p>
    </div>
  </body>
</html>
