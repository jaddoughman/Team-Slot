<?php
session_start();
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta charset = "UTF-8">
<meta http-equiv="X-UA_Compatible" content="IE=edge">


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<link rel="stylesheet" type = "text/css" href="fullcalendar.css">
<link rel="stylesheet" type = "text/css" href="navbar.css">


<meta name = "viewport" content = "width = device-width, initial-scale=1">
<TITLE> Create Team </TITLE>
</HEAD>

<BODY>
<?php include 'navbar.php';?>
<div class='col-sm-9' id="createTeamPage">
<h2> Create A New Team</h2>
<form action="addteam.php" method="get">
  <div class="form-group">
    <label for="teamNameInput">Team Name</label>
    <input type="text" name="teamName" class="form-control" id="teamNameInput" placeholder="Enter Team Name">
    <br>
    <label for="emailsinput"> Invite Members </label>
    <input type="text" class="form-control" name ="emails" placeholder="email accounts of members seperated by a space" id="emailsinput">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


</BODY>
</HTML>



