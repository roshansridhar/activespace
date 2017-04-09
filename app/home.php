<?php
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
</head>
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

</style>
</head>
<body>
<div align="left"><h4> ActiveSpace </h4></div>
<div class="w3-container">
  <h2>H o m e p a g e</h2>
  <p></p>

  <div class="tab_button">
    <button class="tab_button" onclick="existinguser.php?variable_user=$_GET["variable"]>My Live Feed</button>
    <button class="tabs_button" onclick="profile.php?variable1=">My Profile</button>
    <button class="tabs_button" onclick="diary.php?variable1=">My Diary Entry</button>
    <button class="tabs_button" onclick="photos.php?variable1=">My Photos</button>
  </div>
  
  <div id="London" class="tab_button">
    <h2>London</h2>
    <p>London is the capital city of England.</p>
  </div>

  <div id="Paris" class="w3-container w3-border city" style="display:none">
    <h2>Paris</h2>
    <p>Paris is the capital of France.</p> 
  </div>

  <div id="Tokyo" class="w3-container w3-border city" style="display:none">
    <h2>Tokyo</h2>
    <p>Tokyo is the capital of Japan.</p>
  </div>
</div>



<?php 

if(isset($_GET["variable1"])){
$db = pg_connect("host=localhost port=5433 dbname=activespace user=postgres password=test");
$query = "SELECT column_name FROM information_schema.columns where table_schema = 'public' and table_name = '".$_GET['variable1']."';";
$result = pg_query($query); 
while($row = pg_fetch_row($result)){
  echo '<a href="insert.php?variable2='.$row[0].'">'.$row[0].'</a>';
  echo '<br>';
};
;
}
?>

</body>
</html>