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

  <!-- Displaying all posts shared to the network  -->
  
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <title>ActiveSpace: POSTS</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/styles/home.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <div class="container">
        <p align="center"> M   Y       P  O   S   T   S</p>
         <p>
         <?php
         if(isset($_SESSION['EmailID'])){
            $id= "select user_id from userinfo where email_id like '".$_SESSION['EmailID']."';";
            $result1=pg_query($id);
            $id_op=pg_fetch_row($result1);

         
            $query_posts =  "select posts.content,date(posts.post_time),posts.postee_id from posts where posts.poster_id='".$id_op[0]."';";
                     
            $result_posts=pg_query($query_posts);
            echo '<p>';
            while($row = pg_fetch_row($result_posts)){
              if($row[2]==$id_op[0]){
                echo 'YOU broadcasted to EVERYONE on your network';
                echo '<br>';
                echo $row[0]." ".$row[1];
                echo '<br>';
                echo '<br>';
                }

              else{
                echo '<p>';
                echo 'YOU';
                echo ' posted to ';
                
                $id2= "select username from userinfo where user_id = '".(int)$row[2]."';";
                $result2=pg_query($id2);
                $id_op2=pg_fetch_row($result2);

                echo '<a href="search.php?variable_search='.$id_op2[0].'">'.$id_op2[0].'</a>';
                echo '<br>';
                echo $row[0]." ".$row[1];
                echo '<br>';
                echo '<br>';
                echo '</p>';

                }
              echo '</p>';
          }  }
        ?>
      </p>
    </div>
  </body>
</html>
