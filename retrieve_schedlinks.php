<?php

$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";

  // Create connection
  $conn = new mysqli($servername, $username, $password,$db);

  $sql="SELECT LinkID, LinkName, Name FROM SchedLink NATURAL JOIN MemberOf NATURAL JOIN Team WHERE UserID='{$_SESSION["UserID"]}' ";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$linkID=$row['LinkID'];
    	$linkName = $row['LinkName'];
    	$teamName = $row['Name'];
    	//Need to change this when we host !!!
    	$url="schedlink/schedlink_view.php?sl=".$linkID;


    	$sql2 ="SELECT count(*) from TimeSlot WHERE LinkID='$linkID'";
    	$result2=$conn->query($sql2);
    	$row2 = $result2->fetch_assoc();
    	$numberOfSlots = $row2['count(*)'];


    	echo "<div class=\"divbg\">";
    	echo "<h3 class=\"name\"> $linkName </h3>";
    	echo "<p class=\" col-sm-3\"> <span class=\"teamnametag\"> $teamName </span> </p>";
    	echo "<hr>";
    	echo "<p class=\"remainingslots\"> $numberOfSlots slots remaining </p>";
    	echo "<a class=\"SchedLinkButton btn btn-primary\" href=\"$url\" target=\"_blank\"> Go to link</a>";
    	//NEED TO CHANGE LOCALHOST IN URL///
    	echo "<button class=\"SchedLinkButton btn btn-secondary\" onclick=\"copyUrl('teamslot.azurewebsites.net/$url');\"> Copy URL </button>";
    	echo "<button class=\"SchedLinkButton btn btn-secondary\"> Delete link </button>";
    	echo "</div>";

    }
}

  ?>