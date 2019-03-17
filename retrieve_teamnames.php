
<?php
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);

$sql = "SELECT Name,TeamID FROM Team NATURAL JOIN MemberOf WHERE UserID='{$_SESSION['UserID']}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$teamName = $row['Name'];
    	$teamId = $row['TeamID'];
    	
    	echo "<button class=\"btn btn-secondary\" name=\"teamId\" type=\"submit\" value=\"{$teamId}\"> $teamName </button>";
    	echo"<hr>";
    }
}
else 
echo "You need to create a team first"; 

$conn->close();

?>