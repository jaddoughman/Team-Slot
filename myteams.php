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
<link rel="stylesheet" type = "text/css" href="navbar.css">
<link rel="stylesheet" type = "text/css" href="myteams.css">

<meta name = "viewport" content = "width = device-width, initial-scale=1">
<TITLE> My Teams </TITLE>
</HEAD>

<BODY>

<?php include 'navbar.php';?>
<?php include 'retrieve_myteams.php';?>

<a href="createteam_form.php" id="link" class="btn btn-outline-secondary" > New Team </a>


</BODY>
</HTML>