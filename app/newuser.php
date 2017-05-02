<?php
  $invalid_search='';
  $input='';
  $msg='';
  include('../includes/db_connect.php');  
?>

<!-- checks for existing user, else enters new user details in the backed -->
  <?php
    if(isset($_POST["newuser_submit"])){ 

        $querya = "SELECT email_id FROM userinfo WHERE email_id like '$_POST[form_email]';";
        $resa = pg_query($querya) or die("Cannot execute query: $query\n");
        
        $query = " SELECT username from userinfo where username = '$_POST[form_username]' ";
        $result = pg_query($query);
        if(pg_num_rows($result)>0){
    }


        if(pg_num_rows($result)>0){
          echo '<p>Email already exists. Please go back and login with your credentials.</p>';
        }
        else if(pg_num_rows($resa)>0){
            echo "<p>Username already exists. Please choose a different username.</p>";
        }
        else{
          $query = "INSERT INTO userinfo VALUES (DEFAULT,LOCALTIMESTAMP,'$_POST[form_email]','$_POST[form_username]','$_POST[form_password]','$_POST[form_first]','$_POST[form_last]',$_POST[form_phone],'$_POST[form_gender]','$_POST[form_dob]',NULL,LOCALTIMESTAMP,LOCALTIMESTAMP,'".$_POST['about_me_text']."',NULL,$_POST[visibility],$_POST[form_loc]);";
        
          $rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
          echo "<p>New user created successfully. Please log in with your email ID and password on the login screen.</p>";
          echo '<a href="login.php><button> LOGIN </button></a>';}
    }  
  ?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <title>ActiveSpace: New User</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
  
  <a href="home.php" color="#FFCA28"><h4> ActiveSpace </h4></a>
  <div align:"center"; style="color: red; background:rgba(0, 0, 0, .70); font-size: 15px;" ><?php echo $msg ?></div>

<!-- Form for user to fill out details about them -->
   <div align:"center" class="container">
   <p align= "center">Create your profile</p>
     <form align="center" method="POST">
     <p align="center"> 
     <label>Username: <input type="text" name="form_username" required="" /></label><br>
     <label>Password: <input type="password" name="form_password" required="" /></label><br>
     <label>First Name: <input type="text" name="form_first" required="" /></label><br>
     <label>Last Name: <input type="text" name="form_last" required="" /></label><br>
     <label>Email ID: <input type="email" name="form_email" required="" /></label><br>
     <label>Phone: <input type="number" name="form_phone"></label><br>
     <label>Date of Birth: <input type="date" name="form_dob" required="" /></label><br>
     <label><input type="radio" name="form_gender" value=" Male ">Male</label><br>
     <label><input type="radio" name="form_gender" value=" Female ">Female</label><br>
     <label><input type="radio" name="form_gender" value=" Other ">Other</label><br>
     <label>Choose your privacy setting:</label><br>
        <select name="visibility">
          <option value = "0" default>Only Me</option>
          <option value = "1">Friends</option>
          <option value = "2">Friends of friends</option>
          <option value = "3">Everyone</option>
        </select><br>
    <label>About Me:</label><br>
      <textarea name="about_me_text"></textarea>

        <label>Location:</label>        
        <select name="form_loc">
<?php 
                  $lquery = "SELECT loc_id,CONCAT(address,' ',city,' ',state,' ',country) FROM location";
                  $lresult = pg_query($db, $lquery) or die("Cannot execute query: $query\n"); 
                  echo '<option value="null" default>Choose a location from the list...</option>';
                  while($lrow = pg_fetch_row($lresult)){
                    echo '<option value ='.$lrow[0].' '.(($lrow[0]==$row['loc_id'])?'selected = "selected"':"").'>'.$lrow[1].'</option>';
                    }
                echo '</select>'; 
?>
        <a href="addloc.php"><button type="button" name="add_loc" style="float:center;"> + Add Location </button></a>
        <button><input type="submit" value="Submit" name="newuser_submit" width="100" height="100"></button>
        <button><input type="reset" width="100" height="100"></button>
        </form>
      </p>
        </div>
</body>
</html>
