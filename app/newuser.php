<?php
  $db = pg_connect("host=localhost port=5432 dbname=activespace user=postgres password=admin123") or die ("Could not connect to server\n");
?>
<!DOCTYPE html>
<html>
<head>
    <title>ActiveSpace: New User</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <style type="text/css">

        input[type=text], input[type=password], input[type=email], input[type=number], input[type=date] {
        width: 98%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }
        select {
                  width: 98%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }
        textarea{
                  width: 98%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }
        body{
            height:100%;
            width:100%;
            margin-right: 5%;
            /*background-image:url("woman.jpg");*/
            background-size:cover;
            background-size: cover;
            font-size: 16px;
            font-family: 'Oswald', sans-serif;
            font-weight: 300;
            margin: 0;
            color: #666;
        }
        html {
          font-size: 100%;
          line-height: 1.5;
          height: 100%;
        }

        img {
          vertical-align: middle;
          max-width: 100%;
        }
/*        button {
          border-radius: 57px;
          text-shadow: 1px 1px 3px #666666;
          font-family: 'Oswald', sans-serif;
          color: white;
          font-size: 15px;
          background: black;
          padding: 15px;
          text-decoration: none;
          text-align: center;
          vertical-align: center;
        }

        button:hover {
          background: #FFCA28;
          text-decoration: none;
        }*/

        h2 { 
          color: white; 
          text-shadow: 1px 1 white, 1 1px black, 1px 0 black, 0 -1px black; 
          background: rgba(0, 0, 0, .50); font-size: 25px; 
          line-height: 15px; 
          font-weight: 200; 
          float: center; 
          padding: 20px;
          text-align: center; 
          font-family: 'Oswald', sans-serif;
        }

        h3 { 
          color: white; 
          text-shadow: 1px -1 black, 1 0px black, 0px 1 black, 0 1px black; 
          line-height: 15px; 
          font-size: 20px; 
          font-weight: 100; 
          float: left; 
          padding: 5px; 
          margin: 2px; 
          font-family: 'Oswald', sans-serif;
        }

        h4 { 
          color: #FFCA28; 
          background: rgba(0, 0, 0, .80); 
          float: center; 
          padding: 24px; 
          font-family: pacifico; 
          font-size: 50px; 
          font-weight: lighter; 
          line-height: 48px; 
          margin: 0 0 25px; 
          text-align: left; 
          text-shadow: 1px 1px 2px #082b94;
        }
        
        div.container {
            max-width:1800px;
            padding: 16px;
            display: block;
            text-align: center;

        }
        form { display: inline-block;
                text-align: center;
                width: 600px;
        padding: 12px 20px;
        }                 
        body {
        background: -webkit-linear-gradient(0deg, rgba(160,160,160,1) 0%, rgba(160,160,160,1) 0%, rgba(255,255,255,1) 25%, rgba(255,255,255,1) 75%, rgba(160,160,160,1) 100%);
    }


    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <h4> ActiveSpace </h4>
</head>
<body>
    <h2>Create your profile</h2>
        <div class="container">
    <form method="POST" action="login.php" style=" border:1px solid #ccc ">

        <label>Username: <input type="text" name="form_username" required=""></label><br>
        <label>Password: <input type="password" name="form_password" required=""></label><br>
        <label>First Name: <input type="text" name="form_first" required=""></label><br>
        <label>Last Name: <input type="text" name="form_last" required=""></label><br>
        <label>Email ID: <input type="email" name="form_email" required=""></label><br>
        <label>Address: <input type="text" name="form_address"></label><br>
        <label>City: <input type="text" name="form_city"></label><br>
        <label>State: <input type="text" name="form_state"></label><br>
        <label>Country: <input type="text" name="form_country"></label><br>
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
        <textarea id="about_me" rows ="6"></textarea>
        <label style="margin-left:102px;">Location:</label>
<!--         <button type="button" name="create_loc" style="float:right;">+ Add Location</button>
        <select name="form_loc">
          <?php
            // $query = "SELECT CONCAT(address,' ',city,' ',state,' ',country) FROM location";
            // $rs = pg_query($db, $query) or die("Cannot execute query: $query\n"); 
            // while($row = pg_fetch_row($rs)){
            //   echo '<option value ='.$row[0].'>'.$row[0].'</option>';
            //   }
            // echo '</select>';
          ?>
 -->        
        <input type="submit" value="Submit">
        <input type="reset">
        </form>
        </div>
</body>
</html>
<?php
  $query = "INSERT INTO userinfo VALUES (DEFAULT,current_timestamp(),$_POST[form_email],$_POST[form_username],$_POST[form_password],$_POST[form_first],$_POST[form_last],$_POST[form_phone],$_POST[form_gender],$_POST[form_dob],NULL,current_timestamp(),current_timestamp(),$_POST[about_me],NULL,$_POST[visibility],$_POST[form_loc])";
  $rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
  $query = "INSERT INTO location values (DEFAULT,NULL,NULL,$_POST[form_address],$_POST[form_city],$_POST[form_state],$_POST[form_country])";
  $rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
  pg_close($db);  
?>