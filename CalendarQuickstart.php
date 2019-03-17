<?php
require_once __DIR__.'/vendor/autoload.php';
if(!isset($_SESSION['slotFromSchedLinkView']))
  session_start();

$client = new Google_Client();
$client->setAuthConfig(__DIR__.'/client_secret.json');



$client->setScopes(['email']);
$client->addScope(['profile']);
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->addScope("https://www.google.com/m8/feeds/");

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  $client->setAccessToken($_SESSION['access_token']);

  $service = new Google_Service_Calendar($client);

  $google_oauth =new Google_Service_Oauth2($client);

//If coming from index not scheduling link, retrieve events
if(!isset($_SESSION['slotFromSchedLinkView'])){  

$calendarId = 'primary';
$optParams = array(
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
);
$results = $service->events->listEvents($calendarId,$optParams);

//fullcalendar friendly data construction
$events = $results->getItems();
$data =[];

foreach($events as $event){
  $subArr=[
      'id'=>$event->id,
      'title'=>$event->getSummary(),
      'description'=>$event->getDescription(),
      'location'=>$event->getLocation(),
      'start'=>$event->getStart()->getDateTime(),
      'end'=>$event->getend()->getDateTime()

  ];

  array_push($data, $subArr); 
}

$_SESSION["UserEvents"] = json_encode($data);

}


$_SESSION["UserID"] = $google_oauth->userinfo->get()->id;
$_SESSION["NameOfUser"] = $google_oauth->userinfo->get()->name;
$_SESSION["UserImgSrc"] = $img = $google_oauth->userinfo->get()->picture; //profile picture

$_SESSION["UserEmail"]= $google_oauth->userinfo->get()->email;




include 'connecttodb.php';

//check if user is coming from an invitation email
if (! empty($_GET)) {
    $_SESSION["teamIdFromEmail"] = $_GET["teamId"];

    include 'accept_team_invitation.php';
}

//If coming from index not scheduling link, go to fullcalendar
if(!isset($_SESSION['slotFromSchedLinkView'])){
header("Location:fullcalendar.php");
   exit;
}





}

 else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback2.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}


