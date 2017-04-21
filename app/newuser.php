<?php
  $invalid_search='';
  $input='';
  include('../includes/db_connect.php');  
?>

<?php
  $ID='';
  if(isset($_POST["newuser_submit"])){
    $query = " SELECT username from userinfo where username = '$_POST[form_username]' ";
    $result = pg_query($query);
    if(pg_num_rows($result)>0){
        $msg = 'Username already exists. Please choose a different username.';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <title>ActiveSpace: Homepage</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
  
  <a href="home.php" color="#FFCA28"><h4> ActiveSpace </h4></a>

    <div align:"center"; style="color: red; background:rgba(0, 0, 0, .70); font-size: 15px;" ><?php echo $msg ?></div>


      <div class="container">
      <p align= "center">Create your profile</p>

        <form method="POST">
        <p>
        <label>Username: <input type="text" name="form_username" required="" /></label><br>
        <label>Password: <input type="password" name="form_password" required="" /></label><br>
        <label>First Name: <input type="text" name="form_first" required="" /></label><br>
        <label>Last Name: <input type="text" name="form_last" required="" /></label><br>
        <label>Email ID: <input type="email" name="form_email" required="" /></label><br>
        <label>Phone: <input type="number" name="form_phone"></label><br>
        <label>Date of Birth: <input type="date" name="form_dob"></label><br>
        <label><input type="radio" name="form_gender" value="male">Male</label><br>
        <label><input type="radio" name="form_gender" value="female">Female</label><br>
        <label><input type="radio" name="form_gender" value="other">Other</label><br>
        <label>Choose your privacy setting:</label><br>
          <select name="visibility">
            <option default>Choose who can see your profile and uploads...</option>
            <option value = "0">Only Me</option>
            <option value = "1">Friends</option>
            <option value = "2">Friends of friends</option>
            <option value = "3">Everyone</option>
          </select><br>
        <label>About Me:</label><br>
        <textarea id="about_me"></textarea>

        <label>Location:</label>        
        <a href="addloc.php"><button type="button" name="add_loc" style="float:center;"> + Add Location </button></a>
        <select name="form_loc">

          
          <?php
            $query = "SELECT loc_id,CONCAT(address,' ',city,' ',state,' ',country) FROM location";
            $rs = pg_query($db, $query) or die("Cannot execute query: $query\n"); 
            echo '<option default>Choose a location from the list...</option>';
            while($row = pg_fetch_row($rs)){
              echo '<option value ='.$row[0].'>'.$row[1].'</option>';
              }
            echo '</select>';
          ?>

        <input type="submit" value="Submit" name="newuser_submit">
        <input type="reset">
        </form>
      </p>
        </div>
</body>
</html>
<?php
    if(isset($_POST["newuser_submit"])){ 
        $query = "INSERT INTO userinfo VALUES (DEFAULT,LOCALTIMESTAMP,'$_POST[form_email]','$_POST[form_username]','$_POST[form_password]','$_POST[form_first]','$_POST[form_last]',$_POST[form_phone],'$_POST[form_gender]','$_POST[form_dob]',NULL,LOCALTIMESTAMP,LOCALTIMESTAMP,'$_POST[about_me]',NULL,$_POST[visibility],$_POST[form_loc]);";
        $rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
    }
    pg_close($db);  
?>