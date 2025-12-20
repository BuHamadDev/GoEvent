<?php

$event_name = $_POST['event-name'];
$event_date = $_POST['event-date']; 
$event_location = $_POST['event-location'];
$description = $_POST['description'];


echo "Event Created Successfully!<br>";
echo "<dl>
    <dt>Event Name: </dt><dd>$event_name</dd>
    <dt>Event Date: </dt><dd>$event_date</dd>
    <dt>Event Location: </dt><dd>$event_location</dd>
    <dt>Description: </dt><dd>$description</dd>
    </dl>";



?>