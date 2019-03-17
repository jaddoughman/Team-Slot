
<?php
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);


$sql = "SELECT Name,TeamID FROM Team NATURAL JOIN MemberOf WHERE UserID='{$_SESSION['UserID']}'";
$teams = $conn->query($sql);

if ($teams->num_rows > 0) {
    while($row = $teams->fetch_assoc()) {
    	$teamName = $row['Name'];
    	$teamId = $row['TeamID'];

    	echo "<div class=\"teambg\">";
    	echo "<h3 class=\"teamname\"> $teamName </h3>";
    	echo "<form action=\"leave_team.php\" method=\"get\">";
    	echo "<button class=\"btn btn-outline-danger\" id=\"leaveb\" name=\"teamId\" type=\"submit\" value=\"{$teamId}\">Leave Team</button>";
    	echo "</form>";
    	echo "<div class=\"line\"></div>";


    	$sql = "SELECT Fname,Lname,ppsrc FROM User NATURAL JOIN MemberOf WHERE TeamID='{$teamId}'";
    	$members = $conn->query($sql);
    		while($row = $members->fetch_assoc()) {
    			$memberName = $row['Fname']." ".$row['Lname'];
    			$memberppsrc = $row['ppsrc'];

    			echo "<img src=\"{$memberppsrc}\" class=\"memberpp\">";
    			echo "<h5 class=\"membername\"> $memberName </h5>";
    			echo "<br>";
    		}
    	echo "<button type=\"button\" class=\"btn btn-secondary\" id=\"addmemberb\">Add A New Member</button>";
    	echo "</div>";
    }

    
}
else 
echo "You need to create a team first"; 

$conn->close();

?>