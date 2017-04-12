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
  align: left;
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
  margin-top: -40px;
  display: inline-block;
  background-color: rgba(0, 0, 0, .70);
  text-align: center;
  padding: 2px 2px;
  text-decoration: none;
  font-size: 20px;
  margin-left: 10px;
  vertical-align: 5px; 
}

.search{
  float: right;
  margin-top: -40px;
  display: inline-block;
  background-color: rgba(255, 255, 255, .40);
  text-align: center;
  padding: 5px 5px;
  text-decoration: none;
  font-size: 20px;
  color: black;
  margin-right: 10px;
}

div {
  display: inline-block;
     }

input[type="text"]{
    width: 200px;
    display: inline-block;
    border: 5px solid #FFCA28;
    border-radius: 10px;
    font-size: 20px;
    color: #FFCA28;
    background-color: black;
    padding: 10px;
  }


input[type="radio"] {
  display: inline-block;
  font-size: 5px;  
  width: 10px;  
}

div[container_items]{
    width: 588px;
    height: 617px;
    background-color:#000;
    margin: auto;
}

</style>
</head>
<body>

<h4> ActiveSpace </h4>
    <a href="logout.php">
    <img align="right" style="float:right; margin-top: -140px; display: inline-block; padding: 10px 10px;"src="Power_button.png" name="logout" width="70" height="70">
    </a>

    <a href="message.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 100px; display: inline-block; padding: 10px 10px;" src="message.png" name="message" width="50" height="50">
    </a>
    <a href="home.php?variable1=".$_SESSION['EMAIL_ID']><button class="tabs_button">My Live Feed</button></a>
    <a href="profile.php?variable1=".$_SESSION['EMAIL_ID']><button class="tabs_button">My Profile</button></a>
    <a href="diary.php?variable1=".$_SESSION['EMAIL_ID']><button class="tabs_button" onclick="diary.php?variable1=".$_SESSION['EMAIL_ID']>My Diary Entry</button></a>
    <a href="photos.php?variable1=".$_SESSION['EMAIL_ID']><button class="tabs_button">My Photos</button></a>
  <form class="search" action="home.php" align="left" method="post">       
            <div><input type="text" class="form-control" name="Name" placeholder="Search ActiveSpace" />
            <input type="image" alt="Submit" align="center" src="img_search.png" name="submitbutton"  width="50" height="50"></div><br>
            <div><input type="radio" name="Association" value="1" checked /> Friend</div>
            <div><input type="radio" name="Association" value="2"> Friend of Friend</div>
            <div><input type="radio" name="Association" value="3"> Everyone </div><br>

     <div name="container_items" id="container">


<p>Live Feed</p>

</div>
  </form>            
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

