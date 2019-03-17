<div id ="mySidenav" class="sidenav">
<div id="userinfo">
  <img src="<?php echo  $_SESSION["UserImgSrc"];?>">
  <p> <?php echo $_SESSION["NameOfUser"];?> </p>
  </div>
  <a href="/scheduling.php" class = "menus"> Scheduling </a>
  <a href="/fullcalendar.php" class = "menus"> My Calendar</a>
   <a href="/myteams.php" class = "menus"> My Teams</a> <!-- Might change it to groups-->
  <a href="#" class = "menus">Settings</a>
  <!--
  <hr>
  <form action="team_view.php" method="get">
  <?php include 'retrieve_teamnames.php'; ?>
  </form>
  <button type="button"  class="btn btn-secondary" onclick="return displayCreateTeamPage('createTeamPage','calendar');"> Create A New Team </button>
  -->
</div> 

