<?php
session_start();
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta charset = "UTF-8">
<meta http-equiv="X-UA_Compatible" content="IE=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<link rel="stylesheet" type = "text/css" href="navbar.css">
<link rel="stylesheet" type = "text/css" href="scheduling.css">

<meta name = "viewport" content = "width = device-width, initial-scale=1">
<TITLE> Scheduling </TITLE>
</HEAD>

<BODY>

<?php include 'navbar.php';?>

<div id="schedbody">

<div id="navbuttons">
<button class="btn btn-primary navbutton" id="schedlinksb" onclick="showSchedLinks()"> My Scheduling Links </button> 
<button class="btn btn-primary navbutton" id="teameventsb" onclick="showTeamEvents()"> My Team Events </button> 
<button type="button" class="btn btn-primary" id="schedbutton" data-toggle="modal" data-target="#schedModal"> Schedule ! </button>
</div>

<div id="schedlinks">
<?php include 'retrieve_schedlinks.php';?>
</div>

<div id="teamevents" style="display:none">
<?php include 'retrieve_team_events.php';?>
</div>

</div>



<!-- modal to choose scheduling option -->
<div class="modal fade" id="schedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="schedModalLabel"> What would you like to do? </h5>
        <h5 class="modal-title" id="schedModalLabelpickteam" style="display:none"> Pick the team </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body-pickfunction">
      <button type="button" class="btn btn-outline-secondary" onclick="showForm('modal-body-pickteam','modal-body-pickfunction');">Schedule A Team Event</button>
      <hr>
      <button type="button" class="btn btn-outline-secondary" onclick="showForm('modal-body-pickteam-slink','modal-body-pickfunction');" >Create A Scheduling Link For A Team</button>
      </div>
       <div class="modal-body" id="modal-body-pickteam" style="display:none">
        <?php 
        echo "<form action=\"team_view.php\">";
        include 'retrieve_teamnames.php';
        echo "</form>";
        ?>

      </div>

         <div class="modal-body" id="modal-body-pickteam-slink" style="display:none">
        <?php 
        echo "<form action=\"schedlink/schedlink_form.php\">";
        include 'retrieve_teamnames.php';
        echo "</form>";
        ?>

      </div>
      
    </div>
  </div>
</div>

</div>


<script> 
function showForm(shown, hidden) {
  //$('#schedModal').modal('hide');
  document.getElementById(shown).style.display='block';
  document.getElementById(hidden).style.display='none';
  document.getElementById("schedModalLabelpickteam").style.display='block';
  document.getElementById("schedModalLabel").style.display='none';
}


function copyUrl(value){
   var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    alert("Link copied to clipboard");
}

function showTeamEvents(){
  document.getElementById("teamevents").style.display='block';
  document.getElementById("schedlinks").style.display='none';
  console.log(document.getElementById("teamevents").style.display);
  document.getElementById("teameventsb").style.borderWidth='0px';
  document.getElementById("teameventsb").style.borderBottomWidth='5px';
  document.getElementById("teameventsb").style. borderBottomColor='#3498db';
  document.getElementById("teameventsb").style.color='grey';
  document.getElementById("teameventsb").style.backgroundColor='Transparent';
  document.getElementById("teameventsb").style.fontWeight='bold';

  document.getElementById("schedlinksb").style. borderWidth='0px';
  document.getElementById("schedlinksb").style.color='grey';
  document.getElementById("schedlinksb").style.backgroundColor='Transparent';
  document.getElementById("schedlinksb").style.fontWeight='bold';



}

function showSchedLinks(){
  document.getElementById("schedlinks").style.display='block';
  document.getElementById("teamevents").style.display='none';

 document.getElementById("schedlinksb").style.borderWidth='0px';
  document.getElementById("schedlinksb").style.borderBottomWidth='5px';
  document.getElementById("schedlinksb").style. borderBottomColor='#3498db';
  document.getElementById("schedlinksb").style.color='grey';
  document.getElementById("schedlinksb").style.backgroundColor='Transparent';
  document.getElementById("schedlinksb").style.fontWeight='bold';

  document.getElementById("teameventsb").style. borderWidth='0px';
  document.getElementById("teameventsb").style.color='grey';
  document.getElementById("teameventsb").style.backgroundColor='Transparent';
  document.getElementById("teameventsb").style.fontWeight='bold';
}



</script>


</BODY>
</HTML>