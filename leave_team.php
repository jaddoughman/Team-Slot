<?php
	session_start();
?>
<?php
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);

$sql ="DELETE FROM MemberOf WHERE UserID='{$_SESSION['UserID']}' AND TeamID='{$_GET["teamId"]}' ";
$conn->query($sql);


header("Location:myteams.php");
exit;

$conn->close();

?>