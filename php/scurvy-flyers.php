<?php
require_once 'login.php';
$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_username);

$result = $mysqli->query("SELECT * FROM scurvyShows ORDER BY date");

//use mysqli->affected_rows
for ($x = 1; $x <= $mysqli->affected_rows; $x++) {
    $rows[] = $result->fetch_assoc();
}

$mylength = count($rows);
for ($j = 0; $j < $mylength; $j++) {                    
	array_push($rows[$j]);
}



echo "<table border='1' cellspacing='5' cellpadding='5'>";
echo "<tr> <th>Date</th> <th>Facebook</th> <th>Bands</th> <th>Flyer</th></tr>";

for ($j = 0; $j < $mylength; $j++) {
echo "<tr>";
	
	

	
//Our YYYY-MM-DD date string.
$date = $rows[$j]['date'];
 //Convert the date string into a unix timestamp.
$unixTimestamp = strtotime($date);
//Get the day of the week using PHP's date function.
$dayOfWeek = date("D", $unixTimestamp);

$displaydate = $rows[$j]['date'];
$displaydate = date('M jS, Y', strtotime($displaydate));
		
	echo "<td>".$dayOfWeek.", ".$displaydate."</td>";
	
	echo "<td><a href='".$rows[$j]['facebook']."' target='_blank'>Facebook Event</a></td>";

	echo "<td>".$rows[$j]['band01']."<br>".$rows[$j]['band02']."<br>".$rows[$j]['band03']."<br>".$rows[$j]['band04']."<br>".$rows[$j]['band05']."<br>".$rows[$j]['band06']."<br>".$rows[$j]['band07']."<br>".$rows[$j]['band08']."<br>".$rows[$j]['band09']."<br>".$rows[$j]['band10']."<br>".$rows[$j]['band11']."<br>".$rows[$j]['band12']."</td>";

	echo "<td><a href='../images/events/".$rows[$j]['flyerLink']."' target='_blank'><img src='../images/events/".$rows[$j]['thumbLink']."' width='200'  /></a></td>";
	
	echo "</tr>\r";
} 
echo "</table>";

?>