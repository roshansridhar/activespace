<?php
$Invalid_pwd='';
$ID='';
$PWD='';
include('../includes/db_connect.php'); 

#executes on submit button FROM log in form, it checks for invalid user/password else starts session  
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
             $Invalid_pwd = 'Username or Password is invalid. Please try again!';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <title>ActiveSpace: Let's Go!</title>
    <style type="text/css">
    body{
    height:100%;
    width:100%;
    margin-right: 5%;
    background-image:url("home.jpeg");
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

            <!-- FORM-Existing user LOGIN       -->
            <h2 class="heading"> Welcome Back, Lace Up! </h2>
            <input type="text" class="form-control" name="EmailID" placeholder="Email Address" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required=""/>      
            <br>
            <div align="center">
                <input type="image" alt="Submit" src="img_submit.png" name="submitbutton" value="Submit" width="45" height="45">
            </div> 
            <div align:"center"; style="color: red; background:rgba(0, 0, 0, .70); font-size: 15px;" ><?php echo $ID ?></div>
            <div align:"center"; style="color: red; background:rgba(0, 0, 0, .70); font-size: 15px;" ><?php echo $PWD ?></div>
            <div align:"center"; style="color: red; background:rgba(0, 0, 0, .70); font-size: 15px;" ><?php echo $Invalid_pwd ?></div>
        </form>
        <br>
        <br> 
        <br>

            <!-- New User SIGN UP LINK -->
        <h2>Hello There! Lost in Space? There's always something on at ActiveSpace. Let's get started :)</h2>
            <div align="center">
        <a href="newuser.php" class="button"> <button> Sign UP </button> </a>
    </div>

</body>
</html>

          