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
    <title>ActiveSpace: Network</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
        <p align="center"> NETWORK UPDATES</p>
         <p>
         <?php
           if(isset($_SESSION['EmailID'])){              
              $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
              $result1=pg_query($id);
              $userone=pg_fetch_row($result1);

  
              $usertwo=$_GET['request']; 

              $query="select username from userinfo where user_id='".$usertwo."';";
              $username_result=pg_query($query);
              $username_two=pg_fetch_row($username_result);
              echo '<br>';
              $add_friends="select accept_friendship('".(int)$userone[0]."','".(int)$usertwo."');";
              $execute_add=pg_query($add_friends);
              echo "Congratulations! You have successfully connected with ".$username_two[0].". <br> Click Return to go back to your Homepage!";
              echo '<br><br><a href="friendstats.php"><button>RETURN</button></a>';

            }
          ?>
      </p>
    </div>
  </body>
</html>