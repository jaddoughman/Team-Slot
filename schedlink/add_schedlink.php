<?php
session_start();
$timeSlots = explode(',',$_POST['timeSlots']);
$LinkName = $_POST['lname'];
$userId = $_SESSION["UserID"];
$teamId = $_POST['teamId'];
var_dump($timeSlots);
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

$conn = new mysqli($servername, $username, $password,$db);

$sql="INSERT INTO SchedLink(LinkName, TeamID, UserID) VALUES('$LinkName','$teamId','$userId')";


if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    for ($i = 0; $i < count($timeSlots); $i=$i+2) {
    	$start = $timeSlots[$i];
    	$end = $timeSlots[$i+1];

	    $sql="INSERT INTO TimeSlot VALUES('$last_id','$start','$end')";
	    $conn->query($sql);
	}
}

$conn->close();

header("Location:../scheduling.php");

?>