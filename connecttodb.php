
<?php
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);

// Check connection
/*if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";*/



//checking if user already exists in the db (has already signed up)
$sql = "SELECT UserID FROM User WHERE UserID = {$_SESSION['UserID']}";
if($conn->query($sql)->num_rows == 0){
	//split username to first and last name
	$fnamelname = explode(" ", $_SESSION['NameOfUser']);
	//$x = explode("@",$_SESSION["UserEmail"]);
	//$username = $x[0];
	$sql = "INSERT INTO User (UserID, Fname,Lname,username,ppsrc)
	VALUES ('{$_SESSION['UserID']}', '{$fnamelname[0]}','{$fnamelname[1]}','{$_SESSION["UserEmail"]}','{$_SESSION["UserImgSrc"]}')";
	$conn->query($sql);
}


$conn->close();

?>