<?php
  $invalid_search='';
  $input='';
  $visibility='';
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
    <title>ActiveSpace: USERS</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
        <p align="center">PROFILE</p>
         <p>
         <?php
         $currentuser="select user_id from userinfo where email_id='".$_SESSION['EmailID']."';";
         $result1=pg_query($currentuser);
         $userone=pg_fetch_row($result1)[0];


         $profileuser="select user_id from userinfo where username ='".$_GET['variable_search']."';";
         $result2=pg_query($profileuser);
         $usertwo=pg_fetch_row($result2)[0];

         $friendstat="select friendship_status,action_user_id from friendrelation where user_one_id IN (".(int)$userone.",".(int)$usertwo.") and user_two_id IN (".(int)$userone.",".(int)$usertwo.");";
         $result=pg_query($friendstat);

          if($row=pg_fetch_row($result)){
        
            if($row[0]==2){
                echo "<p> You and ".$_GET['variable_search']." are already connected as friends </p>";
                }

            else if(pg_num_rows($result)>0){
              
              if($row[1]== (int)$userone){
                echo "<p> You have already sent ".$_GET['variable_search']." a request to connect </p>";
              }

              if($row[1]==(int)$usertwo){
                echo "<p> ".$_GET['variable_search']." has previously sent you a request to connect.";
                echo '<br><a href="add.php?request='.$usertwo.'">   ADD</a>';
                echo '<br>';
                echo '<a href="decline.php?request='.(int)$usertwo.'">    DECLINE</a>';
                echo '<br></p>';
              }
            }
          }
            else{
              echo "<p> ".$_GET['variable_search']." and you are not currently connected.";
              echo '<a href="add.php?request='.$usertwo.'">   ADD</a>';
            }
        
          

              
            
      

         $query_visibility="select network_visibility from userinfo where user_id ='".(int)$usertwo."';";
         $result=pg_query($query_visibility);
         $vid=pg_fetch_row($result);
         
         if($vid=="0"){
          echo '<br>';
          echo "This user's profile is private. The diary, posts and multimedia are not shared to those on their network";
         }
         else{
          $extract="select username,picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
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
         echo '</p>';

      
         }

         ?>
      </p>
    </div>
  </body>
</html>
