<?php
  $Invalid_search='';
  $input='';
  include('includes/db_connect.php');  
  
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
    <title>ActiveSpace: HomePage</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
<style type="text/css">
 
 h4 { 
  color: #FFCA28; 
  text-shadow: 10px 1 white, 1 10px white, 15px 1 white, 1 20px white; 
  background: rgba(0, 0, 0, .80); 
  font-size: 175px; 
  line-height: 75px; 
  font-weight: 500; 
  margin: 0 5px 24px; 
  float: center; 
  padding: 24px; 
  margin: 0 5px 24px; 
  font-family: pacifico; 
  font-size: 50px; 
  font-weight: lighter; 
  line-height: 48px; 
  margin: 0 0 50px; 
  text-align: left; 
  text-shadow: 1px 1px 2px #082b94;
}

.tabs_button{
  margin: 0 0px -5px; 
  float: left;
  margin-top: -5px; 
}

.search {
  float: right;
  display: inline-block;
  color: white;
  background-color: rgba(0, 0, 0, .70);
  text-align: center;
  padding: 5px 5px;
  text-decoration: none;
  font-size: 20px;
  margin-top: 0px;
  border: groove;
  margin-right: 20px;
  vertical-align: 10px;
}

input[type="text"]{
    width: 100px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 15px;
    color: white;
    background-color: black;
    padding: 10px;
    margin-top: -10px;
  }


input[type="radio"] {
  display: inline-block;
  font-size: 5px;  
   width: 10px;  
}

input[type="submitbutton"] {
  display: block;
  font-size: 5px;  
   width: 10px;  
}


</style>
</head>
<body>

<div align="left"><h4> ActiveSpace </h4></div>
    <div class="tabs_button">
    <button class="tabs_button" onclick="home.php?variable1=".$_SESSION['EMAIL_ID']>My Live Feed</button>
    <button class="tabs_button" onclick="profile.php?variable1=".$_SESSION['EMAIL_ID']>My Profile</button>
    <button class="tabs_button" onclick="diary.php?variable1=".$_SESSION['EMAIL_ID']>My Diary Entry</button>
    <button class="tabs_button" onclick="photos.php?variable1=".$_SESSION['EMAIL_ID']>My Photos</button>
  </div>
  <div align="center">
  <form class="search" action="home.php" align="center" method="post">       
            <p> Search network </p>
            <input type="text" class="form-control" name="Name" placeholder="Enter name" />
            <br>
            <input type="radio" name="Association" value="1" checked /> Friend<br>
            <input type="radio" name="Association" value="2"> Friend of Friend<br>
            <input type="radio" name="Association" value="3"> Everyone <br>
            <div align="right">
            <input type="submit" name="submitbutton" value="Submit">
            </div>
  </form>
  </div>
</body>
</html>


<?php 
  if(isset($_GET["variable1"])){
    echo "Welcome to the Live Feed";
  }
  
  if(isset($_POST["submitbutton"])&&(isset($_GET["variable1'"]))) { 
    $input=$_POST['Association'];    
    
    if(empty($_POST['Name'])) {
        $Invalid_Search= 'No Name or Association input';
    }

    if ($input=="1"){
        $id= "select user_id from userinfo where email_id='".$_GET["variable1"]."';";
        $query = "select username, picture_medium, first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_two_id and friendship_status=2 and user_one_id='".$id."' and first_name like '%".$_POST['Name']."%'
        UNION
        select username, picture_medium first_name, last_name from userinfo, friendrelation where userinfo.user_id=friendrelation.user_one_id and friendship_status=2 and user_two_id='".$id."'and first_name like '%".$_POST['Name']."%';";
        $result = pg_query($query); 
        while($result){
        echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].$row[1].$row[2].$row[3].'</a>';
        echo '<br>';
      }
    }

    if ($input=="2"){
        $id= "select user_id from userinfo where email_id='".$_GET["variable1"]."';";
        $query = "With mutual_user as
        (select user_two_id from friendrelation where friendship_status=2 and user_one_id in
        (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id."')
        UNION
        select user_one_id from friendrelation where friendship_status=2 and user_two_id in
          (select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id."' UNION select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id."'))

        select username, picture_medium, first_name, last_name from userinfo,mutual_user where mutual_user.user_two_id=userinfo.user_id and user_two_id not in(
          select user_two_id from friendrelation where friendship_status=2 and user_one_id='".$id."' UNION
          select user_one_id from friendrelation where friendship_status=2 and user_two_id='".$id."' UNION
          select user_id from userinfo where user_id='".$id."') and first_name like '%".$_POST['Name']."%';";
        $result = pg_query($query); 
        while($result){
        echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].$row[1].$row[2].$row[3].'</a>';
        echo '<br>';
        }
      }

   if ($input=="3"){
      $id= "select user_id from userinfo where email_id='".$_GET["variable1"]."';";
      $query = " select username, picture_medium, first_name, last_name from userinfo where first_name like '".$_POST['Name']."';"; 
       $result = pg_query($query); 
        while($result){
        echo '<a href="search.php?variable_search='.$row[0].'">'.$row[0].$row[1].$row[2].$row[3].'</a>';
        echo '<br>';
      }
    }
  }
?>

