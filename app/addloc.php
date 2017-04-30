<?php
  $invalid_search='';
  $input='';
  include('../includes/db_connect.php');  
  
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

    <div align:"center" class="container">
    <p align= "center">Add a location to the ACTIVESPACE social network</p>
    <form method="POST">
    <p align="center" >
        Address: <input type="text" name="form_address"><br>
        City: <input type="text" name="form_city"><br>
        State: <input type="text" name="form_state"><br>
        Country: <input type="text" name="form_country">
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