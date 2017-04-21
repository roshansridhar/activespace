<?php
  // $invalid_search='';
  // $input='';
  include('../includes/db_connect.php');  
  
  session_start();
  if(!isset($_SESSION[EmailID])){
    session_destroy();
    header('Location: '.'login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <title>ActiveSpace: Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
      <p align= "center">Edit your profile</p>
        <?php
          if(isset($_SESSION[EmailID])){
            $query = "SELECT * FROM userinfo where email_id = '$_SESSION[EmailID]'";
            $result = pg_query($db, $query);
              if($row = pg_fetch_assoc($result)){
                echo '<form method="POST">';
                echo '<p>';
                echo '<label>Username: <input type="text" name="form_username" value="'.htmlspecialchars( $row[username] ).'" required="" /></label><br>';
                echo '<label>Password: <input type="password" name="form_password" value="'.htmlspecialchars( $row[user_password] ).'" required="" /></label><br>';
                echo '<label>First Name: <input type="text" name="form_first" value="'.htmlspecialchars( $row[first_name] ).'" required="" /></label><br>';
                echo '<label>Last Name: <input type="text" name="form_last" value="'.htmlspecialchars( $row[last_name] ).'" required="" /></label><br>';
                echo '<label>Email ID: <input type="email" name="form_email" value="'.htmlspecialchars( $row[email_id] ).'" required="" /></label><br>';
                echo '<label>Phone: <input type="number" name="form_phone" value="'.htmlspecialchars( $row[phone] ).'" ></label><br>';
                echo '<label>Date of Birth: <input type="date" name="form_dob" value="'.htmlspecialchars( $row[date_of_birth] ).'" ></label><br>';
                echo '<label><input type="radio" name="form_gender" '.(($row[gender]=="male")  ?' checked="checked" ':"").' value="male">Male</label><br>';
                echo '<label><input type="radio" name="form_gender" '.(($row[gender]=="female")?' checked="checked" ':"").' value="female">Female</label><br>';
                echo '<label><input type="radio" name="form_gender" '.(($row[gender]=="other") ?' checked="checked" ':"").' value="other">Other</label><br>';
                echo '<label>Choose your privacy setting:</label><br>';
                echo '  <select name="visibility">';
                echo '    <option default>Choose who can see your profile and uploads...</option>';              
                echo '    <option value = "0"'.(($row[network_invisibility]==0)?'selected = "selected"':"").'>Only Me</option>';
                echo '    <option value = "1"'.(($row[network_invisibility]==1)?'selected = "selected"':"").'>Friends</option>';
                echo '    <option value = "2"'.(($row[network_invisibility]==2)?'selected = "selected"':"").'>Friends of friends</option>';
                echo '    <option value = "3"'.(($row[network_invisibility]==3)?'selected = "selected"':"").'>Everyone</option>';
                echo '  </select><br>';
                echo '<label>About Me:</label><br>';



                $query = "SELECT about_me from USERINFO WHERE email_id = '$_SESSION[EmailID]'";
                $result = pg_query($db, $query);
                while($info=pg_fetch_row($finalresult)){
                  echo $info[0];                  
                }
                echo $row[about_me];              
                echo '<textarea id="about_me_text">'.htmlspecialchars( $row['about_me'] ).'</textarea><br>';



                echo '<label>Location:</label>        ';
                echo '<a href="addloc.php"><button type="button" name="add_loc" style="float:center;"> + Add Location </button></a><br>';
                
                echo '<select name="form_loc">';
                  $lquery = "SELECT loc_id,CONCAT(address,' ',city,' ',state,' ',country) FROM location";
                  $lresult = pg_query($db, $lquery) or die("Cannot execute query: $query\n"); 
                  echo '<option default>Choose a location from the list...</option>';
                  while($lrow = pg_fetch_row($lresult)){
                    echo '<option value ='.$lrow[0].' '.(($lrow[0]==$row[loc_id])?'selected = "selected"':"").'>'.$lrow[1].'</option>';
                    }
                  echo '</select>';
                echo '<input type="submit" value="Submit" name="newuser_submit">';
                echo '<input type="reset">';                
                echo '</p>';
                echo '</form>';
            }
          }
        ?>
        </div>
</body>
</html>
