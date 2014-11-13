Hi <?= $person->first_name; ?> <?= $person->last_name; ?>,
<br><br>
<b>Do you have an event today: <?= $event->title; ?>, beginning at <?= date("d-m-Y, H:i", strtotime($event->event_date)); ?>. </b>
<br><br>
Please visit our website for more details. 