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
    <title>ActiveSpace: My Friends</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
        <p>MY FRIENDS</p>
         <p>
          <?php
#CHECK searchbutton
    if(isset($_SESSION['EmailID'])){ 
        
        $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
        $result1=pg_query($id);
        $id_op=pg_fetch_row($result1);

          echo 'Diplaying all friends.';
          echo '<br>';
          echo 'Click on username in the generated list to navigate to their profile.';
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
  ?>
  </p>   
  </div>
  </div>     
</body>
</html>

