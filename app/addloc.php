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
    <title>ActiveSpace: Post IT</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
    <h2>Add a location to the ACTIVESPACE social network</h2>
        <div class="container">
    <form align="center" method="POST" style=" border:1px solid #ccc ">
        <p>
        Address: <input type="text" name="form_address"><br>
        City: <input type="text" name="form_city"><br>
        State: <input type="text" name="form_state"><br>
        Country: <input type="text" name="form_country"><br>
        <p>
        <input type="submit" value="Submit" name="newloc_submit">
        <input type="reset">
        </p>
        </form>
        </div>
</body>
</html>
<?php
  if(isset($_POST["newloc_submit"])){
    $query = "select add_location('".$_POST['form_address']."','".$_POST['form_city']."','".$_POST['form_state']."','".$_POST['form_country']."');";
    $result1=pg_query($query);
    echo 'Location successfully added!' ;
   }
?>