<?php
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
    <title>ActiveSpace: Visibility</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

      <div class="container">
<p align="center">View or change your visibility settings</p>

<!--     <form method ="post">
      <?php
        //   $query = "SELECT user_id FROM userinfo WHERE email_id like '$_SESSION[EmailID]';";
        //   $res = pg_query($query) or die("Cannot execute query: $query\n");
        //   $uid = pg_fetch_row($res);
        // if(isset($_SESSION[EmailID])){
        //   $query = "SELECT username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='$uid[0]'
        //             UNION
        //             select username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='$uid[0]';";          
        //   $result = pg_query($query) or die("Cannot execute query: $query\n");
        //   echo '<select name = "visibility_friend">';
        //     echo '<option default>Choose a friend ...</option>';
        //     while($info = pg_fetch_assoc($result)){
        //       echo '<option value = "'.$info[username].'">'.$info[first_name].' '.$info[last_name].'</option>';
        //     }
        //     echo '</select>';          
        // }
      ?>
      <input type="submit" value="Submit" name="selection_friend">
      </form> -->
      <form method="post">
      <p align="center">
      <?php
          $query = "SELECT * FROM userinfo WHERE username like '$_SESSION[EmailID]';";
          $res = pg_query($query) or die("Cannot execute query: $query\n");
          $uid = pg_fetch_row($res);
          if(isset($_SESSION[EmailID])){
                echo '  <select name="visibility_option">';
                echo '    <option default>Choose who can see your profile and uploads...</option>';              
                echo '    <option value = "0"'.(($row[visibility_status]==0)?'selected = "selected"':"").'>Only Me</option>';
                echo '    <option value = "1"'.(($row[visibility_status]==1)?'selected = "selected"':"").'>Friends</option>';
                echo '    <option value = "2"'.(($row[visibility_status]==2)?'selected = "selected"':"").'>Friends of friends</option>';
                echo '    <option value = "3"'.(($row[visibility_status]==3)?'selected = "selected"':"").'>Everyone</option>';
                echo '  </select><br>';
                echo '</select>';          
          }
      ?>
      <input type="submit" value="Submit" name="visibility_selection">
      </p>
      </form>
    </div>
  </body>
</html>

<?php
    if(isset($_POST["visibility_selection"])){
      $query = "UPDATE userinfo SET network_visibility = $_POST[visibility_option] WHERE email_id = '$_SESSION[EmailID]';";
      $rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
      echo "Visibility settings edited successfully.";
    }
?>