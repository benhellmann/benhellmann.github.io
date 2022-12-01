<?php
require_once 'login.php';
$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_username);

$result = $mysqli->query("SELECT * FROM mototour_europe17");

//use mysqli->affected_rows
for ($x = 1; $x <= $mysqli->affected_rows; $x++) {
    $rows[] = $result->fetch_assoc();
}

$mylength = count($rows);
for ($j = 0; $j < $mylength; $j++) {                    
	array_push($rows[$j]);
}



echo "<table border='1' cellspacing='5' cellpadding='5'>";
echo "<tr> <th>Date</th> <th>Venue</th> <th>Town</th> <th>Country</th> <th>Map</th></tr>";

for ($j = 0; $j < $mylength; $j++) {
echo "<tr>";
	
	

	
//Our YYYY-MM-DD date string.
$date = $rows[$j]['date'];
 //Convert the date string into a unix timestamp.
$unixTimestamp = strtotime($date);
//Get the day of the week using PHP's date function.
$dayOfWeek = date("D", $unixTimestamp);

$displaydate = $rows[$j]['date'];
$displaydate = date('d M', strtotime($displaydate));
		
	echo "<td>".$dayOfWeek." ".$displaydate."</td>";
	
	// venue and venue link:
	if ($rows[$j]['url1'] == NULL) {  // if there isn't a facebook link, try the venue website link instead
          $venuelink = $rows[$j]['url2'];
        } else {
          $venuelink = $rows[$j]['url1'];
        }
    
    if ($venuelink == NULL) {
      echo "<td>".$rows[$j]['venue']."</td>";
    } else {
      echo "<td><a href='".$venuelink."' target='_blank'>".$rows[$j]['venue']."</a></td>";
    }

	
	echo "<td>".$rows[$j]['town']."</td>";
	echo "<td>".$rows[$j]['country']."</td>";
	echo "<td><a href='".$rows[$j]['map']."' target='_blank'>".$rows[$j]['address']."</a></td>";
	
	echo "</tr>\r";
} 
echo "</table>";

?>