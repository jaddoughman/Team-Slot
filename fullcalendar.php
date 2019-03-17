<?php
session_start();
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta charset = "UTF-8">
<meta http-equiv="X-UA_Compatible" content="IE=edge">
<link rel="stylesheet" type = "text/css" href="fullcalendar.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.js"></script>

<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script type='text/javascript' src='fullcalendar/gcal.js'></script>

<script>
  
  $(document).ready(function() {

  // page is now ready, initialize the calendar...

  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay,listMonth'
    },
    events : <?php echo $_SESSION["UserEvents"];?> ,
    eventLimit: true, // allow "more" link when too many events
      themeSystem : 'bootstrap3',
      selectOverlap : false,
      aspectRatio: 2,
      selectable : true,
      eventColor : 'rgb(83, 149, 252)',
      eventTextColor : 'white',
      eventClick:  function(event, jsEvent, view) {
            $('#modalTitle').html(event.title);
            if(event.description ==null)
              event.description = "No description";
            $('#modalBody').html("<b> Description : </b>" +event.description+"<br>");
            if(event.location ==null){
              event.location = "No Location";
              $('#modalBody').append("<b> Location : </b>"+event.location);
            }
            
            else{
            var map = "https://www.google.com/maps/place/";
            var location = event.location;
            var url = map.concat(location);
            var type = "?type=individual";
            var res = url.concat(type);
            $('#modalBody').append("<b> Location : </b>" +"<a href=\""+res+"\" target=\"_blank\">"+event.location +" </a>");
            }

            $('#fullCalModal').modal();
            
        }

  })

});

</script>

<meta name = "viewport" content = "width = device-width, initial-scale=1">
<TITLE> My Calendar</TITLE>

</style>
</HEAD>

<BODY>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<?php include 'navbar.php'; ?>


<div class='col-sm-9' id="calendarwrap" >
<div id='calendar'> </div>
</div>


<!-- Event onClick Popup to show location and description -->
<div id="fullCalModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
            <h4 id="modalTitle" class="modal-title"></h4>
            <div id="modalBody" class="modal-body"></div>
    </div>
  </div>
</div>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

  $(document).ready(function() {
        openNav();

    });



</script>


</BODY>
</HTML>