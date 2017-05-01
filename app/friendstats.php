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
           $query= "select username from userinfo where email_id='".$_SESSION['EmailID']."';"; 
           $result=pg_query($query); 
           if($row = pg_fetch_row($result)){ 
             echo $row[0].'! ActiveSpace Messages :'; 
           } 
              
          echo '<br>'; 
  
 // obtain the userid 
         $currentuser="select user_id from userinfo where email_id='".$_SESSION['EmailID']."';"; 
           $currentuser="select user_id from userinfo where email_id='".$_SESSION['EmailID']."';"; 
         $result1=pg_query($currentuser); 
         $userone=pg_fetch_row($result1)[0]; 
  
 // obtain all the userids from user table to check if new friend requests have been sent or accepted 
         $profileuser="select user_id from userinfo;"; 
         $result2=pg_query($profileuser); 
                
         echo '<p><br> FRIEND REQUESTS and ACCEPTS <br><br>'; 
  
 // Displays the previously accepted friend requests with timestamps and pending request  
         while($usertwo=pg_fetch_row($result2)){ 
           $friendstat="select action_user_id from friendrelation where  
               friendship_status='1' and user_one_id IN (".(int)$userone.",".(int)$usertwo[0].") and user_two_id IN (".(int)$userone.",".(int)$usertwo[0].");"; 
           $result=pg_query($friendstat); 
           $row= pg_fetch_row($result); 
  
 //Friend requests 
           if(pg_num_rows($result)>0){ 
             if($row[0]==(int)$usertwo[0]){ 
               echo "<p> "; 
               $query= "select username,picture_medium from userinfo where user_id='".(int)$row[0]."';"; 
               $result=pg_query($query); 
               $user_msg = pg_fetch_row($result); 
               echo '<a href="search.php?variable_search='.$user_msg[0].'">'.$user_msg[0]."</a> has sent you a request to connect."; 
               echo '<br><a href="accept.php?request='.(int)$row[0].'"><button>   ACCEPT INVITE </button></a>'; 
               echo '<a href="decline.php?request='.(int)$row[0].'"><button>    DECLINE INVITE </button></a>'; 
               echo '<br>'; 
               echo '</p>'; 
               } 
           } 
  

           $friendstat="select action_user_id,action_taken_time from friendrelation where  
               friendship_status='2' and user_one_id IN (".(int)$userone.",".(int)$usertwo[0].") and user_two_id IN (".(int)$userone.",".(int)$usertwo[0].");"; 
           $result=pg_query($friendstat); 
           $row= pg_fetch_row($result); 
  
 //Accepted friend requests 
           if(pg_num_rows($result)>0){ 
             if($row[0]==(int)$userone[0]){ 
               echo "<p> "; 
                
               $query= "select username,picture_medium from userinfo where user_id='".$usertwo[0]."';"; 
               $result=pg_query($query); 
               $user_msg = pg_fetch_row($result); 
               echo '<a href="search.php?variable_search='.$user_msg[0].'">'.$user_msg[0]."</a> has accepted your request to connect on ".$row[1]." !!"; 
               echo '<br>'; 
               echo '</p>'; 
             } 
           } 
         }}

          ?>
        </p>
      </div>
    </body>
  </html>