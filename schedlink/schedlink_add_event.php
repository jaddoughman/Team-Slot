<?php
session_start();
$_SESSION['slotFromSchedLinkView'] = $_POST['slot'];
$_SESSION['teamIdFromSchedLinkView'] = $_POST['teamId'];
$_SESSION['schedLinkIdFromSchedLinkView'] = $_POST['schedLinkId'];
$_SESSION['teamNameFromSchedLinkView'] = $_POST['teamName'];

include '../CalendarQuickstart.php';


$slotArray = explode(',',$_SESSION['slotFromSchedLinkView']);
$slotStart = $slotArray[0];
$slotEnd = $slotArray[1];


//Remove the chosen slot from the database
$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);

$sql="DELETE FROM TimeSlot WHERE LinkID ='{$_SESSION['schedLinkIdFromSchedLinkView']}' AND start='$slotStart' AND TimeSlot.end ='$slotEnd'";

$conn->query($sql);


$sql="SELECT username FROM User NATURAL JOIN MemberOf WHERE TeamID ='{$_SESSION['teamIdFromSchedLinkView']}'";
	$result = $conn->query($sql);
	$memberEmails = array();

    while($row = $result->fetch_assoc()) {
    	array_push($memberEmails,$row['username']);
    }

    $attendeeArrayForGoogle=array();
    foreach ($memberEmails as $email) {
    	
    	array_push($attendeeArrayForGoogle,array('email'=> $email));
    }

$conn->close();


	$client = new Google_Client();
	$client->setAuthConfig('../client_secret.json');
	$client->setScopes(['email']);
	$client->addScope(['profile']);
	$client->addScope(Google_Service_Calendar::CALENDAR);
	$client->addScope("https://www.google.com/m8/feeds/");
	$client->setAccessToken($_SESSION['access_token']);
	$service = new Google_Service_Calendar($client);

	$event = new Google_Service_Calendar_Event(array(
    'summary' => $_SESSION["NameOfUser"]." - ".strtoupper($_SESSION['teamNameFromSchedLinkView']),
    //'location' => $location,
    'description' => " Powered By TeamSlot",
    'start' => array(
    'dateTime' => $slotStart,
    'timeZone' => 'Asia/Beirut',
    ),
    'end' => array(
    'dateTime' => $slotEnd,
    'timeZone' => 'Asia/Beirut',
    ),
  
    'attendees' => $attendeeArrayForGoogle,

  ));

  $calendarId = 'primary';
  $event = $service->events->insert($calendarId, $event);


  $_SESSION['eventUrlFromSchedLink'] = $event->htmlLink;


  //because using isset $_SESSION["slotFromSchedLinkView"] in calendarquickstart
  unset ($_SESSION["slotFromSchedLinkView"]);

  header("Location:add_event_success.php");


?>