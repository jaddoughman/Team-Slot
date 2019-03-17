<?php
session_start();



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


$servername = "den1.mysql6.gear.host";
$username = "teamslot";
$password = "teamslot123$";
$db = "teamslot";




// Create connection
$conn = new mysqli($servername, $username, $password,$db);


$client = new Google_Client();

$client->setAccessToken($_SESSION['access_token']);

$service = new Google_Service_Calendar($client);


$sql="INSERT INTO Team(Name) VALUES('{$_GET['teamName']}')";
$conn->query($sql);

//get the team's ID (because Auto-Increment)
//Will cause problems if there are multiple teams with same name. It should be implemented with $conn->insert_id
$sql = "SELECT TeamID FROM Team WHERE Name ='{$_GET['teamName']}'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$teamID = $row['TeamID'];
//used for the submit value in the email


$sql="INSERT INTO MemberOf VALUES('{$_SESSION['UserID']}','{$teamID}')";
$conn->query($sql);


$emails = explode(" ", $_GET['emails']);


//Send invitation emails to specified accounts
$mail = new PHPMailer(true); // Passing `true` enables exceptions
try {
    //Server settings
    //$mail->SMTPDebug = 2;   // Enable verbose debug output
    $mail->isSMTP();     // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                 // Enable SMTP authentication
    $mail->Username = 'teamslotmailer@gmail.com';     // SMTP username
    $mail->Password = 'teamslot@mailer1';          // SMTP password
    $mail->SMTPSecure = 'ssl';      // Enable TLS encryption, `ssl` alsoaccepted
    $mail->Port = 465;         // TCP port to connect to

    //Recipients
    $mail->setFrom('teamslotmailer@gmail.com', 'TeamSlot');
    foreach($emails as $email){
        $mail->addAddress($email);  
    }


    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Invitation to join a team !';
    //$mail->Body    = file_get_contents("team_invitation_mailform.php");
    $mail->Body =  '<h1> Hi there, '. $_SESSION["NameOfUser"] . ' would like you to join ' .$_GET['teamName'].' on TeamSlot</h1>
 <form action="localhost/teamslot/CalendarQuickstart.php" method="get">
<button class="btn btn-secondary" name="teamId" type="submit" value= "'. $teamID. '"> Accept Invitation </button>
<p><small> By accepting the invitation, you would be giving '.$_SESSION["NameOfUser"]. ' and other members of '.$_GET['teamName'].' the ability to view the busy times on your primary calendar</small></p>
</form>'; 

    $mail->send();
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
//Add Email accounts to PendingMemberOf
foreach($emails as $email){
    $sql = "INSERT INTO PendingMemberOf values('{$email}','{$teamID}')";
    $conn->query($sql);

    //inserting acl rules from admin to member

    $rule = new Google_Service_Calendar_AclRule();
    $scope = new Google_Service_Calendar_AclRuleScope();

    $scope->setType("user");
    $scope->setValue($email);
    $rule->setScope($scope);
    $rule->setRole("freeBusyReader");

    $optParams = array(
    'sendNotifications' => false,
);

    $createdRule = $service->acl->insert('primary', $rule, $optParams);
}


$conn->close();

header("Location:myteams.php");
exit;

?>