<?php
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

$conn = new mysqli($servername, $username, $password,$db);

$sql="SELECT start,TimeSlot.end FROM TimeSlot WHERE LinkID ='$schedLinkId'";
$result = $conn->query($sql);


	if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
    		$startTime = new DateTime($row['start']);
    		$endTime = new DateTime($row['end']);

    		$slotDisplayString = $startTime->format('D j F H:i').$endTime->format('- H:i');

    		$slotString = $startTime->format('Y-m-d\TH:i:s').','.$endTime->format('Y-m-d\TH:i:s');
    		echo "<button class=\"btn btn-dark\" name=\"slot\" type=\"submit\" value=\"$slotString\" id=\"slotButton\"> $slotDisplayString </button>";
    		echo "<br>";
   		}
	}

    else 
        echo "No Available Times";


	


?>