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
    <title>ActiveSpace: Diary IT</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
        <p align="center">Share a DIARY ENTRY today!</p>
        <form action="upload_diary.php" method="post" enctype="multipart/form-data">
        <br>
        <p align="center"> Type in about your latest ventures:<br>
        <input type="text" class="description" name="title" placeholder="Enter title" />
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input type="text" class="description" name="Description" placeholder="Entry" />

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

        <input type="image" alt="Submit" src="img_submit.png" name="submitbutton" value="Submit" width="45" height="45">
        <input type="reset">

        </p>
        
        </form>
        <p>
        
        <?php
          if(isset($_POST["submitbutton"])) {
            if(empty($_GET['fileToUpload'])){
                  $title = $_POST['title'];
                        // Gets description from POST 
                        $description = $_POST['Description'];
                        // Gets photo name

                        $location= $_POST['form_loc'];
                $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
                        $result1=pg_query($id);
                        $id_op=pg_fetch_row($result1);
                        $query = "select upload_diary('".$title."','".$description."',NULL,'".$location."','".$id_op[0]."');";
                        $result = pg_query($query);
                echo 'Diary entry without image is being uploaded';
                
            } 
            else {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } 
                else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        // Gets description from POST 
                        $title = $_POST['title'];
                        // Gets description from POST 
                        $description = $_POST['Description'];
                        // Gets photo name
                        $filename = basename($_FILES["fileToUpload"]["name"]);

                        $location= $_POST['form_loc'];

                        $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
                        $result1=pg_query($id);
                        $id_op=pg_fetch_row($result1);
                        $query = "select upload_diary('".$title."','".$description."','".$filename."','".$location."','".$id_op[0]."');";
                        $result = pg_query($query);
                        echo "Diary Entry has been successfully uploaded! <br><br> Click on Diary Entry in navigation bar to check out the latest uploads!";

                    }
                
                    
                    // If moving a file does not work.
                    else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
             
        
        ?>
      </p>
    </div>
  </body>
</html>
