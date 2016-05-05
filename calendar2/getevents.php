<?php
// List of events
 $json = array();


 // Query that retrieves events

 $requete = "SELECT * FROM calendar ORDER BY id";

 //connect to the database
 mysql_connect("localhost", "root", "root") or die (mysql_error());
 mysql_select_db("ackward") or die(mysql_error());

 //query that retrieves all the events
 $selectQuery = "SELECT * FROM event ORDER BY id";

// Execute the query
 $ArrayOfEvents = mysql_query($selectQuery)
 if($type == 'fetch') {
   $events = array();
  
   while($fetch = mysql_fetch_array($ArrayOfEvents)) {

   	while($row = mysql_fetch_array($rs)) {

	   // Write the value of the column FirstName (which is now in the array $row)
	 echo $fetch['title']
     $e = array();
     $e['id'] = $fetch['id'];
     $e['title'] = $fetch['title'];
     $e['start'] = $fetch['time'];
     array_push($events, $e);
   }
   echo json_encode($events);
}


?>