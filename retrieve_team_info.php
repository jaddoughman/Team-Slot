<?php
	require_once __DIR__.'/vendor/autoload.php';
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);

	//need to retrieve team name and team members for now 

	$sql="SELECT Name FROM Team WHERE TeamID ='{$_SESSION['teamIdFromTeamView']}' "; 
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
    $_SESSION['teamNameForTeamView'] = $row['Name'];

    $sql="SELECT Fname, Lname FROM User NATURAL JOIN MemberOf WHERE TeamID = '{$_SESSION['teamIdFromTeamView']}'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    	$_SESSION['teamMembers'] = array(); 
    	while($row = $result->fetch_assoc()) {
    		array_push($_SESSION['teamMembers'], $row['Fname'] ." ". $row['Lname']);

   		}
	}

	$sql="SELECT username FROM User NATURAL JOIN MemberOf WHERE TeamID = '{$_SESSION['teamIdFromTeamView']}'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    	$requestItems = array(); 
    	while($row = $result->fetch_assoc()) {
    		$requestItem = new Google_Service_Calendar_FreeBusyRequestItem();
    		$requestItem->setId($row['username']);
    		array_push($requestItems, $requestItem);

   		}
	}

	//Not sure if it is good practice to re-write the code for client and service initialization. Might cause problems.. ?
	$client = new Google_Client();
	$client->setAuthConfig('client_secret.json');
	$client->setScopes(['email']);
	$client->addScope(['profile']);
	$client->addScope(Google_Service_Calendar::CALENDAR);
	$client->addScope("https://www.google.com/m8/feeds/");

	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  	$client->setAccessToken($_SESSION['access_token']);

  	$service = new Google_Service_Calendar($client);

	$freebusy_req = new Google_Service_Calendar_FreeBusyRequest();

	$timeMin = date("Y-m-d\T00:00:00\Z");
    $timeMax = strtotime(date("Y-m-d\T00:00:00\Z", strtotime($timeMin)) . " +2 month");
    $timeMax = date("Y-m-d\T00:00:00\Z",$timeMax);  


	$freebusy_req->setTimeMin($timeMin);
	$freebusy_req->setTimeMax($timeMax);
	$freebusy_req->setTimeZone('Asia/Beirut');
	$freebusy_req->setItems($requestItems);
	$result =$service->freebusy->query($freebusy_req);

	$BusyInfo = array();
	$calendars=$result->getCalendars();
	foreach ($calendars as $calendar) {
		array_push($BusyInfo,$calendar->getBusy());
	}

	//1 dimensional array containing all TimePeriods for all calendars in the request
	$slots = array();
	foreach ($BusyInfo as $bI) {
		foreach ($bI as $timePeriod) {
			array_push($slots,$timePeriod);
		}
	}

	

  // event array for fullcalendar
  $fullcalendarBusySlots =[];

	foreach($slots as $slot){
  		$BusySlot=[
      		//'title'=>"",
  			'id'=>"10",
      		'start'=>$slot->start,
      		'end'=>$slot->end,
      		'rendering'=>'background',
      		'color'=> '#ff3838'

  		];

 		array_push($fullcalendarBusySlots, $BusySlot); 
	}
}

?>