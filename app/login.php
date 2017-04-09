<?php
$Invalid_pwd='';
$ID='';
$PWD='';
include('includes/db_connect.php'); 

  
if(isset($_POST["submitbutton"])){     
    if(empty($_POST['EmailID'])) {
        $ID= 'No Email ID input';
    }
    else if(empty($_POST['password'])) {
        $PWD= 'No Password input';
    }
    else{
        $query = "select * from userinfo where user_password = '".$_POST['password']."' and email_id= '".$_POST['EmailID']."';";
        $result = pg_query($query);
        if(pg_num_rows($result)>0){
            session_start();
            $_SESSION['EmailID']=$_POST['EmailID'];
            header('Location: '.'home.php');
        }
        else{
             $Invalid_pwd = 'Username or Password is invalid. Please try again or seek Forgot password help!';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css">
    <title>ActiveSpace: Let's Go!</title>
    <style type="text/css">
    body{
    height:100%;
    width:100%;
    margin-right: 5%;
    background-image:url("login_img.jpg");
    background-size:cover;
    background-size: cover;
    font-size: 16px;
    font-family: 'Oswald', sans-serif;
    font-weight: 300;
    margin: 0;
    }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    </style>
    <h4> ActiveSpace </h4>
    <div align="center">
         <form class="signin" action="login.php" align="center" method="post">       
            <h2 class="heading"> Welcome Back, Lace Up! </h2>
            <input type="text" class="form-control" name="EmailID" placeholder="Email Address" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required=""/>      
            <br>
            <h3><a href="Forgotpwd.php">Can't recall the password?</a></h3>
            <div align="center">
                <input type="submit" name="submitbutton" value="Submit">
            </div> 
        </form>
        <br>
        <br> 
        <br>
        <h2>Hello There! Lost in Space? There's always something on at ActiveSpace. Let's get started :)</h2>
            <div align="center">
        <a href="newuser.php" class="button"> <button> Sign UP </button> </a>
    </div>
    <div style="color: red; background:rgba(0, 0, 0, .50); font-size: 25px;" align:"center"><?php echo $ID ?></div>
        </div>
    <div style="color: red; background:rgba(0, 0, 0, .50); font-size: 25px;" align:"center"><?php echo $PWD ?></div>
        </div>
    <div style="color: red; background:rgba(0, 0, 0, .50); font-size: 25px;" align:"center"><?php echo $Invalid_pwd ?></div>
</body>
</html>

          
