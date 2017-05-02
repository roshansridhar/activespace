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
         $result_stat=pg_query($friendstat);
         $row=pg_fetch_row($result_stat);

         $searchuser=$_GET['variable_search'];

         $query_visibility="select network_visibility from userinfo where user_id ='".(int)$usertwo."';";
         $result=pg_query($query_visibility);
         $vid=pg_fetch_row($result);

         $queryfof = "With mutual_user as
                    (select user_two_id from friendrelation where friendship_status=2 and user_one_id in
                    (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".(int)$userone."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".(int)$userone."')
                      UNION
                    select user_one_id from friendrelation where friendship_status=2 and user_two_id in
                    (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".(int)$userone."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".(int)$userone."'))

                    select user_id from userinfo,mutual_user where mutual_user.user_two_id=userinfo.user_id and user_two_id not in(
                    select user_two_id from friendrelation where friendship_status=2 and user_one_id='".(int)$userone."' UNION
                    select user_one_id from friendrelation where friendship_status=2 and user_two_id='".(int)$userone."' UNION
                    select user_id from userinfo where user_id='".(int)$userone."');";
          $resultfof =pg_query($queryfof);


          if((int)$userone==(int)$usertwo){

            echo 'The following is how your profile is visible to everyone';
            
            $extract="select username,picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
            $finalresult=pg_query($extract);
            
            echo '<p>';
              
            while($info=pg_fetch_row($finalresult)){
              echo 'USERNAME :'.$info[0].'<br>';
               echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
              echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
              echo '<p>A little bit about me :'.$info[4].'</p><br>';
              echo '<p> Things that interests :'.$info[5].'</p><br>';
              echo '<p>Hit me up! :'.$info[6].'<br>';
              echo 'Gender :'.$info[7].'<br>';
              echo 'Birthday :'.$info[8].'<br><br>';
              echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
            }
         
          echo '</p>';
          echo '<br><br><br><p>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';
          echo '<br><br></p>';
         }


          else if($row[0]==2){
                    echo "<p>";
                    echo " You and ".$_GET['variable_search']." are already connected as friends </p>";
                    echo '<br><a href="decline.php?request='.(int)$usertwo.'"><button> DROP FRIENDSHIP </button><a>';
                    echo "</p>";


                  if ($vid[0]==0){
                   echo "User does not share his Posts/Diary/Photos"; 
                  }

                  else{
                    
                   echo '<br>';
          
          $extract="select username, picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
          $finalresult=pg_query($extract);
          
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
           echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
         echo '<br><br><br><p>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';
          echo '<br><br></p>';
         }

          }
                  

          else if($row[0]==1){
              
                  if($row[1]== (int)$userone){

                      echo "<p> You have already sent ".$_GET['variable_search']." a request to connect </p>";

                  if (($vid[0]==0)||($vid[0]==1)){
                   echo "User does not share his Posts/Diary/Photos"; 
                  }

                  if($vid[0]==2){
                    echo '<p> User shares posts with Friends of Friends, if you can view the profile you have mutual friends! </p>';
                      while($rowfof = pg_fetch_row($resultfof)){
                        if(($vid[0]==2)&&($rowfof[0]==(int)$usertwo)){
                    
          echo '<p><br> Friend of a Friend!<br></p>';
          
          $extract="select username, picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
          $finalresult=pg_query($extract);
          
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
           echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
         echo '<br><br><br><p>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';          
          echo '<br><br></p>';
         }
         
         
         }}
          if($vid[0]==3){
                $extract="select username, picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
          $finalresult=pg_query($extract);
          
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
           echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
         echo '<br><br>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';
          echo '<br>';
              }

              

              }

                    


                   else if($row[1]==(int)$usertwo){
                      echo "<p> ";
                      echo $_GET['variable_search']." has previously sent you a request to connect.";
                      echo '<br><a href="accept.php?request='.(int)$usertwo.'"><button>   ACCEPT INVITE </button></a>';
                      echo '<a href="decline.php?request='.(int)$usertwo.'"><button>    DECLINE INVITE </button></a>';
                      echo '<br>';
                      echo '</p>';


                  if ($vid[0]==0){
                   echo "<p>User does not share his Posts/Diary/Photos</p>"; 
                  }
                  
                  
         else{
          $extract="select username, picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
          $finalresult=pg_query($extract);
          
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
         echo '<br><br>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';
          echo '<br>';
              }

                  }
                }
          
          
          else{
              echo "<p> ";
              echo $_GET['variable_search']." and you are not currently connected.";
              echo '<a href="add.php?request='.(int)$usertwo.'"><button>   ADD TO NETWORK </button></a>';
              echo "</p> ";

              echo '<br>';
          
          if ($vid[0]==0){
                   echo "<p>User does not share his Posts/Diary/Photos</p>"; 
                  }
          if ($vid[0]==1){
                   echo "<p>User does not share his Posts/Diary/Photos</p>"; 
                  }
           if($vid[0]==2){
                    echo '<p> User shares posts with Friends of Friends, if you can view the profile you have mutual friends! </p>';       
          while($rowfof = pg_fetch_row($resultfof)){


                  if(($vid[0]==2)&&($rowfof[0]==(int)$usertwo)){
                    
          echo '<p><br> Friend of Friend <br></p>';
          
          $extract="select username, picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
          $finalresult=pg_query($extract);
          
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
           echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
         echo '<br><br>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';
          echo '<br>';
         }
                }}

          if($vid[0]==3){
          $extract="select username, picture_medium, first_name,last_name,about_me,interests,phone,gender,date_of_birth, last_log_in from userinfo where user_id='".(int)$usertwo."';" ;
          $finalresult=pg_query($extract);
          
          echo '<p>';
          while($info=pg_fetch_row($finalresult)){
           echo 'USERNAME :'.$info[0].'<br>';
           echo '<img class= "imageformat" src="uploads/'.$info[1].'" float="center" width="100" height="150">';
           echo 'FULL NAME :'.$info[2]." ".$info[3].'<br><br>';
           echo '<p>A little bit about me :'.$info[4].'</p><br>';
           echo '<p> Things that interests :'.$info[5].'</p><br>';
           echo '<p>Hit me up! :'.$info[6].'<br>';
           echo 'Gender :'.$info[7].'<br>';
           echo 'Birthday :'.$info[8].'<br><br>';
           echo '<br> Last seen on ActiveSpace :'.$info[9].'<br></p>';
         }
         echo '<br><br>';
          echo '<a href="user_diary.php?item='.$searchuser.'"><button class="tabs_button"> Diary Entry</button></a>';
          echo '<a href="user_photos.php?item='.$searchuser.'"><button class="tabs_button"> Photos</button></a>';
          echo '<a href="user_posts.php?item='.$searchuser.'"><button class="tabs_button"> Posts</button></a>';
          echo '<a href="user_friends.php?item='.$searchuser.'"><button class="tabs_button"> Friends</button></a>';
          echo '<br>';
              }
            }
            
         ?>
      </p>
    </div>
  </body>
</html>
