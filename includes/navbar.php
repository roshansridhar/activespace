<a href="home.php" color="#FFCA28"><h4> ActiveSpace </h4></a>
    <a href="logout.php">
    <img align="right" style="float:right; margin-top: -140px; display: inline-block; padding: 10px 10px;"src="Power_button.png" name="logout" width="70" height="70">
    </a>

    <a href="visibility.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 100px; display: inline-block; padding: 10px 10px;" src="gear.png" name="message" width="50" height="50">
    </a>

    <a href="notifications.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 200px; display: inline-block; padding: 10px 10px;" src="notification.png" name="message" width="50" height="50">
    </a>

    <a href="message.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 300px; display: inline-block; padding: 10px 10px;" src="message.png" name="message" width="50" height="50">
    </a>

    <a href="friendstats.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 400px; display: inline-block; padding: 10px 10px;" src="friend.png" name="message" width="50" height="50">
    </a>

    <a href="edituser.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 500px; display: inline-block; padding: 10px 10px;" src="editprofile.png" name="message" width="50" height="50">
    </a>

    <a href="events.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 600px; display: inline-block; padding: 10px 10px;" src="events.png" name="message" width="50" height="50">
    </a>


    <a href="home.php" ><button class="tabs_button">My Live Feed</button></a>
    <a href="profile.php"><button class="tabs_button">My Profile</button></a>
    <a href="diary.php"><button class="tabs_button" onclick="diary.php?variable1=".$_SESSION['EMAIL_ID']>My Diary Entry</button></a>
    <a href="photos.php"><button class="tabs_button">My Photos</button></a>
    <a href="posts.php"><button class="tabs_button">My Posts</button></a>
    

    <form class="search" action="../app/search_results.php" align="left" method="post">       
      <div class="searchbox">
        <input type="text" class="form-control" name="Name" placeholder="Search Network" />
        <input type="image" alt="Submit" align="center" src="search_human.png" name="searchbutton"  width="50" height="50"></div><br>
        <div class="searchbox">
          <input type="radio" name="Association" value="1" checked /> Friend
        </div>
        <div class="searchbox">
          <input type="radio" name="Association" value="2"> Friend of Friend
        </div>
        <div class="searchbox">
          <input type="radio" name="Association" value="3"> Everyone 
        </div>
        <br>
      </div>
    </form> 

<form class="search" action="../app/search_key_results.php" align="left" method="post">       
      <div class="searchbox">
        <input type="text" class="form-control" name="Name" placeholder="Search ActiveSpace" />
        <input type="image" alt="Submit" align="center" src="search_posts.png" name="searchbutton"  width="50" height="50"></div><br>
        <div class="searchbox">
          <input type="radio" name="Association" value="1" checked /> Posts
        </div>
        <div class="searchbox">
          <input type="radio" name="Association" value="2"> Photos
        </div>
        <div class="searchbox">
          <input type="radio" name="Association" value="3"> Diary
        </div>
        <div class="searchbox">
          <input type="radio" name="Association" value="4"> Events 
        </div>
        <div class="searchbox">
          <input type="radio" name="Association" value="5"> Location 
        </div>
        <br>
      </div>
    </form> 

