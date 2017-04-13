<a href="home.php" color="#FFCA28"><h4> ActiveSpace </h4></a>
    <a href="logout.php">
    <img align="right" style="float:right; margin-top: -140px; display: inline-block; padding: 10px 10px;"src="Power_button.png" name="logout" width="70" height="70">
    </a>

    <a href="message.php">
    <img align="right" style="float:right; margin-top: -125px; margin-right: 100px; display: inline-block; padding: 10px 10px;" src="inbox.gif" name="message" width="50" height="50">
    </a>

    <a href="home.php" ><button class="tabs_button">My Live Feed</button></a>
    <a href="profile.php"><button class="tabs_button">My Profile</button></a>
    <a href="diary.php"><button class="tabs_button" onclick="diary.php?variable1=".$_SESSION['EMAIL_ID']>My Diary Entry</button></a>
    <a href="photos.php"><button class="tabs_button">My Photos</button></a>
    

    <form class="search" action="../app/search_results.php" align="left" method="post">       
      <div class="searchbox">
        <input type="text" class="form-control" name="Name" placeholder="Search ActiveSpace" />
        <input type="image" alt="Submit" align="center" src="img_search.png" name="searchbutton"  width="50" height="50"></div><br>
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