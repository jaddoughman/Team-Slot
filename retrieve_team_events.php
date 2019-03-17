<?php

$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

  // Create connection
  $conn = new mysqli($servername, $username, $password,$db);
  $eventData = $conn->query("SELECT title,location,description, Name, startTime, finishTime FROM event NATURAL JOIN team WHERE UserID ='{$_SESSION['UserID']}' ");    
 
  if ($eventData->num_rows > 0) {
  while($row = $eventData->fetch_assoc()) {
  $Title = $row['title'];
  $Location=$row['location'];
  $Description=$row['description'];
  $teamName = $row['Name'];

  
  $date= date_create_from_format('Y-m-d H:i:s',$row['startTime']);
  $finishTime = date_create_from_format('Y-m-d H:i:s',$row['finishTime']);
  $duration = $finishTime->diff($date);

  $duration= $duration->format("%Hh %Im");
  $date = $date->format('D F j \a\t H:i');


  echo "<div class=\"divbg\">";
  echo "<h3 class=\"name\"> $Title </h3>";
  echo "<p class=\" col-sm-3\"> <span class=\"teamnametag\"> $teamName </span> </p>";
  echo "<p> Location: <span class=\"data\"> $Location </span> </p>";
  echo "<p> Description: <span class=\"data\"> $Description </span> </p>";
  echo "<p> Date and Time: <span class=\"data\"> $date </span> </p>";
  echo "<p> Duration: <span class=\"data\"> $duration </span> </p>";
  echo "</div>";


  }
}
else {
  echo "team events that you create will appear here";
}
   
 

?> 