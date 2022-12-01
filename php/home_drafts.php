<?php
require_once 'login.php';
$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_username);

$result = $mysqli->query("SELECT * FROM products, brands WHERE products.brand = brands.brand AND products.isTapped='1' ORDER BY products.weight DESC ");

//use mysqli->affected_rows
for ($x = 1; $x <= $mysqli->affected_rows; $x++) {
    $rows[] = $result->fetch_assoc();
}

$mylength = count($rows);
for ($j = 0; $j < $mylength; $j++) {
                    
	// determine number of servings by inventory size and serving size:
	if (($rows[$j]['inventorySize'] == '5.1 gallons') && ($rows[$j]['servingSize'] == '16 ounces')) {  // American log, 16 ounce pours
          $num_servings = 40.8;
        }
	elseif (($rows[$j]['inventorySize'] == '5.1 gallons') && ($rows[$j]['servingSize'] == '12 ounces')) {  // American log, 12 ounce pours
          $num_servings = 54.4;
        }
	elseif (($rows[$j]['inventorySize'] == '5.1 gallons') && ($rows[$j]['servingSize'] == '10 ounces')) {  // American log, 10 ounce pours
          $num_servings = 65.28;
        }
    elseif (($rows[$j]['inventorySize'] == '7.75 gallons') && ($rows[$j]['servingSize'] == '16 ounces')) {  // American 1/4 barrel, 16 ounce pours
          $num_servings = 62;
		}
	 elseif (($rows[$j]['inventorySize'] == '7.75 gallons') && ($rows[$j]['servingSize'] == '10 ounces')) {  // American 1/4 barrel, 10 ounce pours
          $num_servings = 99.2;
        }
    elseif (($rows[$j]['inventorySize'] == '7.92 gallons') && ($rows[$j]['servingSize'] == '16 ounces')) {  // European 1/4 barrel, 16 ounce pours
          $num_servings = 63.36;
		}
	elseif (($rows[$j]['inventorySize'] == '7.92 gallons') && ($rows[$j]['servingSize'] == '10 ounces')) {  // European 1/4 barrel, 10 ounce pours
          $num_servings = 101.376;
		}
    elseif (($rows[$j]['inventorySize'] == '13.2 gallons') && ($rows[$j]['servingSize'] == '20 ounces')) {  // European/short 1/2 barrel, 20 ounce pours
          $num_servings = 84.48;
		}
    elseif (($rows[$j]['inventorySize'] == '13.2 gallons') && ($rows[$j]['servingSize'] == '16 ounces')) {  // European/short 1/2 barrel, 16 ounce pours
          $num_servings = 105.6;
		}
	elseif (($rows[$j]['inventorySize'] == '13.2 gallons') && ($rows[$j]['servingSize'] == '10 ounces')) {  // European/short 1/2 barrel, 10 ounce pours
          $num_servings = 168.96;
		}
    elseif (($rows[$j]['inventorySize'] == '15.5 gallons') && ($rows[$j]['servingSize'] == '16 ounces')) {  // American 1/2 barrel, 16 ounce pours
          $num_servings = 124;
		}
	elseif (($rows[$j]['inventorySize'] == '15.5 gallons') && ($rows[$j]['servingSize'] == '10 ounces')) {  // American 1/2 barrel, 10 ounce pours
          $num_servings = 198.4;
		}
    else {
          echo "need more serving size data";
        }
	array_push($rows[$j],$num_servings); // this gets the value into the real main array, but without the proper key  // array position: [0] => $num_servings
        
	// determine our cost per serving
	$costPerServing = ($rows[$j]['inventoryPrice'] / $num_servings);
    array_push($rows[$j],$costPerServing); // this gets the value into the real main array, but without the proper key  // array position: [1] => $costPerServing

	// determine our profit per serving
	$profitPerServing = ($rows[$j]['servingPrice'] - $costPerServing);
    array_push($rows[$j],$profitPerServing); // this gets the value into the real main array, but without the proper key  // array position: [2] => $profitPerServing
	
	// determine our profit per serving if we sell for half price
	$profitPerServingEmployee = (($rows[$j]['servingPrice'] / 2) - $costPerServing);
    array_push($rows[$j],$profitPerServingEmployee); // this gets the value into the real main array, but without the proper key  // array position: [3] => $profitPerServingEmployee
	
	// calculate our profit percentage
	$profitPercentage = (($rows[$j]['servingPrice'] / $costPerServing) * 100);
    array_push($rows[$j],$profitPercentage); // this gets the value into the real main array, but without the proper key  // array position: [4] => $profitPercentage
	
}






for ($j = 0; $j < $mylength; $j++) {
	
	if ($rows[$j]['BA_link'] == NULL) {  // if there isn't a beer advocate link, try the ratebeer link instead
          $rows[$j]['BA_link'] = $rows[$j]['RB_link'];
        }
	
	echo "<a href=\"".$rows[$j]['BA_link']."\" rel=\"external\">".$rows[$j]['brand']." ".$rows[$j]['type']."</a> (".number_format((float)($rows[$j]['ABV']), 1, '.', '')."%)<br />";
} 

?>