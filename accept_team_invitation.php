<?php 
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";


// Create connection
$conn = new mysqli($servername, $username, $password,$db);


	$sql="INSERT INTO MemberOf values('{$_SESSION["UserID"]}','{$_SESSION['teamIdFromEmail']}') ";
	$conn->query($sql);

	$sql="DELETE FROM PendingMemberOf WHERE username='{$_SESSION['UserEmail']}' AND TeamID='{$_SESSION['teamIdFromEmail']}' ";
	$conn->query($sql);



$sql="SELECT username FROM User NATURAL JOIN MemberOf WHERE TeamID = '{$_SESSION['teamIdFromEmail']}'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    	$ACLvalues = array(); 
    	while($row = $result->fetch_assoc()) {
    		array_push($ACLvalues, $row['username'] );

   		}
   	}
$sql="SELECT username FROM PendingMemberOf WHERE TeamID = '{$_SESSION['teamIdFromEmail']}'";
	$result = $conn->query($sql);
if ($result->num_rows > 0) { 
    	while($row = $result->fetch_assoc()) {
    		echo $row['username'];
    		array_push($ACLvalues, $row['username'] );
    	}
    	
}


$conn->close();

//print_r($ACLvalues);


foreach ($ACLvalues as $username) {
	if($username !== $_SESSION['UserEmail']){
    $rule = new Google_Service_Calendar_AclRule();
    $scope = new Google_Service_Calendar_AclRuleScope();

    $scope->setType("user");
    $scope->setValue($username);
    $rule->setScope($scope);
    $rule->setRole("freeBusyReader");

    $optParams = array(
    'sendNotifications' => false,
	);

    $createdRule = $service->acl->insert($_SESSION['UserEmail'], $rule, $optParams);
	}
} 



?>