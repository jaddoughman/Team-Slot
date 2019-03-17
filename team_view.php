<?php
session_start();
//Is that bad practice ? (need this session for the php file that will retrieve all team info according to the team id)
$_SESSION['teamIdFromTeamView'] = $_GET["teamId"];

//check if request is coming from the scheduling link form to change fullcalendar's select function
$originIsSchedLinkForm = strpos($_SERVER['HTTP_REFERER'], 'schedlink_form') !== false ;


include 'retrieve_team_info.php'
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta charset = "UTF-8">
<meta http-equiv="X-UA_Compatible" content="IE=edge">
<link rel="stylesheet" type = "text/css" href="team_view.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.js"></script>

<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<link href="fullcalendar/fullcalendar-teamview.css" rel="stylesheet">
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script type='text/javascript' src='fullcalendar/gcal.js'></script>

<script>
  
  var slots = [];
  var numberOfSlots = 0;
  //var totalTime = 0;
  
  $(document).ready(function() {

  // page is now ready, initialize the calendar...
 

  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'agendaWeek'
    },
    events :<?php echo json_encode($fullcalendarBusySlots) ;?>,
    eventLimit: true, // allow "more" link when too many events
      
      aspectRatio: 2,
      selectable : true,
      eventColor : '#1abc9c',
      defaultView :'agendaWeek',
      scrollTime:'08:00:00',
      selectHelper: true,
      <?php 
      if(! $originIsSchedLinkForm) {
        echo "select: function(start, finish) {
        
        $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
        $('#ModalAdd #finish').val(moment(finish).format('YYYY-MM-DD HH:mm:ss'));
        $('#ModalAdd').modal('show');

      },";
      }

      else {
        echo"select: function (start, end, jsEvent, view) {
          
    $(\"#calendar\").fullCalendar('addEventSource', [{
        start: start,
        end: end,
    }, ]);
    slots.push(start.format('YYYY-MM-DD HH:mm:ss'));
    slots.push(end.format('YYYY-MM-DD HH:mm:ss'));
    numberOfSlots = numberOfSlots+1;
    $(\"#calendar\").fullCalendar(\"unselect\");
},";
      }

      ;?>
     
   editable: true,
   selectOverlap : false

  })

  

});

function sendSlots(path) {

    method = "post"; // Set method to post by default if not specified.
    params = {timeSlots: slots, numOfSlots: numberOfSlots , teamId :<?php echo $_GET["teamId"] ;?>};
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit(); 
}


</script>

<meta name = "viewport" content = "width = device-width, initial-scale=1">
<TITLE> <?php echo $_SESSION['teamNameForTeamView'];?> </TITLE>
</HEAD>

<BODY>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>




<!--<p> add js to show team mebers on the side afer clicking a button</p>-->
<h4> Members : </h4>
<?php 
  foreach ($_SESSION['teamMembers'] as $member) {
  	echo $member."<b> | </b>";
  } 
  ?>

  <?php
if($originIsSchedLinkForm)
  echo "<button class=\"btn btn-success\" onclick=\"sendSlots('schedlink/schedlink_form.php')\" id=\"doneButton\"> Done </button>";
;?>

  <form action="scheduling.php">
    <button type="submit" class="btn btn-secondary" id="closeButton"> &times;</button>
</form>

<div class='col-sm-9' id="calendarwrap" >
<div id='calendar'> </div>
</div>





<!-- Add Event Modal -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form class="form-horizontal" method="POST" action="add_team_event.php">
      

        <div class="modal-body">
          <div class="form-group">
          <label for="title" class="col-sm-2 control-label"><b>Title</b></label>
          <div class="col-sm-10">
            <input type="text" name="title" class="form-control" id="title" placeholder="Title">
          </div>
          </div>


          <div class="form-group">
          <label for="location" class="col-sm-2 control-label"><b>Location (Optional)</b></label>
          <div class="col-sm-10">
            <input type="text" name="location" class="form-control" id="location" placeholder="location">
          </div>
          </div>


          <div class="form-group">
          <label for="description" class="col-sm-2 control-label"><b>Description (Optional)</b></label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" type="text" rows="4" placeholder="Event Description" id= "description"></textarea>
          </div>
          </div>

          <div class="form-group">
          <label for="start" class="col-sm-10 control-label"><b>Start time</b></label>
          <div class="col-sm-10">
            <input type="text" name="start" class="form-control" id="start" placeholder="Start Time">
          </div>
          </div>

          <div class="form-group">
          <label for="finish" class="col-sm-10 control-label"><b>End time</b></label>
          <div class="col-sm-10">
            <input type="text" name="finish" class="form-control" id="finish" placeholder="End Time">
          </div>
          </div>
        
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Event</button>
        </div>
      </form>
      </div>
      </div>
    </div>



</BODY>
</HTML>