<?php
$schedLinkId = $_GET['sl'];

$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

$conn = new mysqli($servername, $username, $password,$db);
$sql ="SELECT TeamID, Name FROM SchedLink NATURAL JOIN Team WHERE LinkID='$schedLinkId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teamId = $row['TeamID'];
    $teamName = $row['Name'];
}



?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta charset = "UTF-8">
<meta http-equiv="X-UA_Compatible" content="IE=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<link rel="stylesheet" type = "text/css" href="schedlink_view.css">

<meta name = "viewport" content = "width = device-width, initial-scale=1">

<TITLE> <?php echo "Scheduling Link -".$teamName;?> </TITLE>
</HEAD>

<BODY>

<div id="landing">
<a href="../index.php"> <img src="../img/teamslot-logo.png" id="logo"> </a>
<div id="slotpicker">
<b id="slotpickerheader">Pick a time to meet with <?php echo $teamName;?> </b>
<hr>
<form action="schedlink_add_event.php" method="POST">
<input type="hidden" value=<?php echo"\"".$teamId."\"" ;?> name="teamId" />
<input type="hidden" value=<?php echo"\"".$schedLinkId."\"" ;?> name="schedLinkId" />
<input type="hidden" value=<?php echo"\"".$teamName."\"" ;?> name="teamName" />
<?php include 'retrieve_schedlink_slots.php'; ?>
</form>
</div>
</div>

<div id="success" style="display:none">
<img src="../img/success.png" id="success" >
<p id="successtext">The meeting is set ! </p>
<a id="eventlink" href= <?php echo "\"".$_SESSION['eventUrlFromSchedLink']."\"";?> target="_blank" class ="btn btn-primary"> Click here to view the calendar event </a>
</div>

</BODY>
</HTML>