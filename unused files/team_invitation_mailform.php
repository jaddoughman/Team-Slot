<?php
	session_start();
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type = "text/css" href="team_invitation_mailform.css">

<h1> Hi there, InviteeName would like you to join TeamName on TeamSlot</h1>
 <form action="teamslot.azurewebsites.net/CalendarQuickstart.php" method="get">
<button class="btn btn-secondary" name="teamId" type="submit" value= "<?php echo $_SESSION['teamIdInEmail'];?>"> Accept Invitation </button>
</form>