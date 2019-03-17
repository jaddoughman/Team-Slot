<?php
session_start();
$originIsTeamView = strpos($_SERVER['HTTP_REFERER'], 'team_view') !== false ;
if($originIsTeamView)
	$teamId = $_POST['teamId'];
else
	$teamId = $_GET['teamId'];

?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta charset = "UTF-8">
<meta http-equiv="X-UA_Compatible" content="IE=edge">


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<link rel="stylesheet" type = "text/css" href="../navbar.css">
<link rel="stylesheet" type = "text/css" href="schedlink_form.css">

<meta name = "viewport" content = "width = device-width, initial-scale=1">
<TITLE> Create Scheduling Link </TITLE>
</HEAD>

<BODY>
 <?php include '../navbar.php';?> 

 <form action="/scheduling.php">
    <button type="submit" class="btn btn-secondary" id="closeButton"> Cancel</button>
</form>


<div id="schedLinkForm">


  		<form action="../team_view.php">
  		<button class="btn btn-secondary" name="teamId" type="submit" value= <?php echo "\"$teamId\"" ;?> > Pick Available Times </button>
  		</form>

  		<?php 
  		if(isset($_POST['numOfSlots'])){
  			echo "<small> you selected ". $_POST['numOfSlots'] ." slots. </small>";
  		}

  		;?>



<br>
<br>

<form method="POST" action ="add_schedlink.php" >
  	<div class="form-group row">
         	 <label for="title" class="col-sm-5 control-label"><b>Link Name (Not shown to meeting requestor) </b></label> 
          	<div class="col-sm-10">
           	 <input type="text" name="lname" class="col-sm-5 form-control" placeholder="What type of meetings will be scheduled with this link ? ">
  	</div>
  	 </div>

  	

	<?php
		if(isset($_POST['timeSlots'])){
			echo "<input type=\"hidden\" value=\"" . $_POST['timeSlots'] ."\"name=\"timeSlots\" />";
			echo "<input type=\"hidden\" value=\"" . $teamId ."\"name=\"teamId\" />";
		}
	;?>

	 <button type="submit" class="btn btn-primary "> Create Link </button>

</form>

</div>
 



</BODY>
</HTML>
