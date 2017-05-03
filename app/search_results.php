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
          echo 'Diplaying all friends. Please enter name/substring in the search box';
          echo '<br>';
          echo 'Click on username in the generated list to navigate to user profile';
          echo '<br><br>';

          $query = "select username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."'
                    UNION
                    select username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."';";
          $result2=pg_query($query);
          echo '<p>';
              while($row = pg_fetch_row($result2)){
          echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
          echo 'PROFILE PICTURE:<img class= "imageformat" src="uploads/'.$row[1].'"><br><br>';
          echo $row[2]." ".$row[3];
          echo '<br>';
          }
          echo '</p>';
        }

        if ($input=="2"){
          echo 'Diplaying all of your friends of friends. Please search for specific name in the search box';
          echo '<br>';
          echo 'Click on the username in the list generated to navigate to user profile';
          echo '<br><br>';
      
          $query = "With mutual_user as
                    (select user_two_id from friendrelation where friendship_status=2 and user_one_id in
                    (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id_op[0]."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id_op[0]."')
                      UNION
                    select user_one_id from friendrelation where friendship_status=2 and user_two_id in
                    (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id_op[0]."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id_op[0]."'))

                    select username, picture_medium, first_name, last_name from userinfo,mutual_user where mutual_user.user_two_id=userinfo.user_id and user_two_id not in(
                    select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id_op[0]."' UNION
                    select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id_op[0]."' UNION
                    select user_id from userinfo where user_id='".$id_op[0]."');";
          $result2=pg_query($query);

          echo '<p>';
          while($row = pg_fetch_row($result2)){
            echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
            echo '<img class= "imageformat" src="uploads/'.$row[1].'" float="center" width="50" height="70">';
            echo '<br>';
            }
          echo '</p>';
          }

        if ($input=="3"){
          echo 'Diplaying all of members in the network. Please search for specific name in the search box';
          echo '<br>';
          echo 'Click on the username in the list generated to navigate to user profile';
          echo '<br>';
          echo '<br>';
          
          $query = " select username, picture_medium, first_name, last_name from userinfo"; 
          $result=pg_query($query);
          echo '<p>';
          while($row = pg_fetch_row($result)){
            echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
            echo '<img class= "imageformat" src="uploads/'.$row[1].'" float="center" width="50" height="70">';
          echo $row[2]." ".$row[3];
            echo '<br>';
            }
          echo '</p>';
          }

        }
    

        else{

        $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
        $result1=pg_query($id);
        $id_op=pg_fetch_row($result1);


    	     if ($input=="1"){
            $query = "select username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id_op[0]."' and first_name like '%".$_POST['Name']."%' or last_name like '%".$_POST['Name']."%' or username like '%".$_POST['Name']."%'
            UNION
            select username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id_op[0]."'and first_name like '%".$_POST['Name']."%' or last_name like '%".$_POST['Name']."%' or username like '%".$_POST['Name']."%';";
            $result2=pg_query($query);
            
            if(pg_num_rows($result2)>0){
                echo 'Click on the username in the list generated to navigate to user profile';
                echo '<br><br>';
                echo '<p>';
              while($row = pg_fetch_row($result2)){
                echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
                echo '<img class= "imageformat" src="uploads/'.$row[1].'" float="center" width="50" height="70">';
          echo $row[2]." ".$row[3];
                echo '<br>';
                }
              echo '</p>';
              }
            
            else{
              echo '<p>Invalid input. Please try again</p>';
            }
          }

    	   if ($input=="2"){
            $query = "With mutual_user as
                      (select user_two_id from friendrelation where friendship_status=2 and user_one_id in
                      (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id_op[0]."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id_op[0]."')
                      UNION
                      select user_one_id from friendrelation where friendship_status=2 and user_two_id in
                      (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id_op[0]."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id_op[0]."'))

                      select username, picture_medium, first_name, last_name from userinfo,mutual_user where mutual_user.user_two_id=userinfo.user_id and user_two_id not in(
                      select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id_op[0]."' UNION
                      select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id_op[0]."' UNION
                      select user_id from userinfo where user_id='".$id_op[0]."') and first_name like '%".$_POST['Name']."%' or last_name like '%".$_POST['Name']."%' or username like '%".$_POST['Name']."%';";
       

              $result2=pg_query($query);
              
              if(pg_num_rows($result2)>0){
                echo 'Click on the username in the list generated to navigate to user profile';
                echo '<br><br>';
                echo '<p>';
                while($row = pg_fetch_row($result2)){
                  echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
                  echo '<img class= "imageformat" src="uploads/'.$row[1].'" float="center" width="50" height="70">';
          echo $row[2]." ".$row[3];
                  echo '<br>';
                  }      
                  echo '</p>';
                }
            
              else{
                echo '<p>Invalid input. Please try again</p>';
                }
              }

          if ($input=="3"){
              $query = " select username, picture_medium, first_name, last_name from userinfo where first_name like '%".$_POST['Name']."%' or last_name like '%".$_POST['Name']."%' or username like '%".$_POST['Name']."%';"; 
              $result2= pg_query($query);

              if(pg_num_rows($result2)>0){
                echo 'Click on the username in the list generated to navigate to user profile';
                echo '<br><br>';
                echo '<p>';
                while($row = pg_fetch_row($result2)){
                  echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].'</a>';
                   echo '<img class= "imageformat" src="uploads/'.$row[1].'" float="center" width="50" height="70">';
                  echo '<br>';
                }
                echo '</p>';
              }
              else{
                echo '<p>Invalid input. Please try again</p>';
                } 
              }
        }
      }
  ?>
  </p>   
  </div>
  </div>     
</body>
</html>

