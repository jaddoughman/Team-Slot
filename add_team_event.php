<?php
require_once __DIR__.'/vendor/autoload.php';
session_start();

$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";
$conn = new mysqli($servername, $username, $password,$db);


if ( isset( $_POST['title']) && isset($_POST['start']) && isset($_POST['finish']) ){
	
	$title = $_POST['title'];
	$location = $_POST['location'];
	$description = $_POST['description'];
	$start = $_POST['start'];
	$finish = $_POST['finish'];
	$UserID = $_SESSION["UserID"];
	$TeamID = $_SESSION['teamIdFromTeamView'];

	// ADD TO GOOGLE CALENDAR
	$startForGoogleArray = explode(' ',$start);
	$startForGoogle = $startForGoogleArray[0]."T".$startForGoogleArray[1];

	$finishForGoogleArray = explode(' ',$finish);
	$finishForGoogle = $finishForGoogleArray[0]."T".$finishForGoogleArray[1];

	$sql="SELECT username FROM User WHERE UserID='$UserID'";
	$result = $conn->query($sql);
	$userEmail='';
	while($row = $result->fetch_assoc()) {
    	$userEmail = $row['username'];
    }

	$sql="SELECT username FROM User NATURAL JOIN MemberOf WHERE TeamID ='$TeamID'";
	$result = $conn->query($sql);
	$memberEmails = array();

    while($row = $result->fetch_assoc()) {
    	array_push($memberEmails,$row['username']);
    }

    $attendeeArrayForGoogle=array();
    foreach ($memberEmails as $email) {
    	if($email != $userEmail)
    	array_push($attendeeArrayForGoogle,array('email'=> $email));
    }

	$client = new Google_Client();
	$client->setAuthConfig('client_secret.json');
	$client->setScopes(['email']);
	$client->addScope(['profile']);
	$client->addScope(Google_Service_Calendar::CALENDAR);
	$client->addScope("https://www.google.com/m8/feeds/");
	$client->setAccessToken($_SESSION['access_token']);
	$service = new Google_Service_Calendar($client);

	$event = new Google_Service_Calendar_Event(array(
    'summary' => $title." - ".strtoupper($_SESSION['teamNameForTeamView']),
    'location' => $location,
    'description' => $description."\n -- Powered By TeamSlot",
    'start' => array(
    'dateTime' => $startForGoogle,
    'timeZone' => 'Asia/Beirut',
    ),
    'end' => array(
    'dateTime' => $finishForGoogle,
    'timeZone' => 'Asia/Beirut',
    ),
  
    'attendees' => $attendeeArrayForGoogle,

  ));

  $calendarId = 'primary';
  $event = $service->events->insert($calendarId, $event);


  $url = $event->htmlLink;

	//ADD TO DATABASE
	$sql = "INSERT INTO Event(title, location, description, startTime, finishTime, UserID, TeamID, URL) values ('$title', '$location', '$description', '$start', '$finish', '$UserID', '$TeamID','$url')";
	$conn->query($sql);


	
}

$conn->close();
header('Location:scheduling.php');

	
?>