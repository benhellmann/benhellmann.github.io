<?php
require_once 'login.php';
$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_username);

$result = $mysqli->query("SELECT * FROM products_bottles, brands WHERE products_bottles.brand = brands.brand AND products_bottles.isTapped='1' ORDER BY products_bottles.weight DESC ");

//use mysqli->affected_rows
for ($x = 1; $x <= $mysqli->affected_rows; $x++) {
    $rows2[] = $result->fetch_assoc();
}

$mylength = count($rows2);
for ($j = 0; $j < $mylength; $j++) {
                    
	// determine number of servings by inventory size and serving size:
	if (($rows2[$j]['inventorySize'] == '5.1 gallons') && ($rows2[$j]['servingSize'] == '16 ounces')) {  // American log, 16 ounce pours
          $num_servings = 40.8;
        }
	elseif (($rows2[$j]['inventorySize'] == '5.1 gallons') && ($rows2[$j]['servingSize'] == '12 ounces')) {  // American log, 12 ounce pours
          $num_servings = 54.4;
        }
	elseif (($rows2[$j]['inventorySize'] == '5.1 gallons') && ($rows2[$j]['servingSize'] == '10 ounces')) {  // American log, 10 ounce pours
          $num_servings = 65.28;
        }
    elseif (($rows2[$j]['inventorySize'] == '7.75 gallons') && ($rows2[$j]['servingSize'] == '16 ounces')) {  // American 1/4 barrel, 16 ounce pours
          $num_servings = 62;
		}
	 elseif (($rows2[$j]['inventorySize'] == '7.75 gallons') && ($rows2[$j]['servingSize'] == '10 ounces')) {  // American 1/4 barrel, 10 ounce pours
          $num_servings = 99.2;
        }
    elseif (($rows2[$j]['inventorySize'] == '7.92 gallons') && ($rows2[$j]['servingSize'] == '16 ounces')) {  // European 1/4 barrel, 16 ounce pours
          $num_servings = 63.36;
		}
	elseif (($rows2[$j]['inventorySize'] == '7.92 gallons') && ($rows2[$j]['servingSize'] == '10 ounces')) {  // European 1/4 barrel, 10 ounce pours
          $num_servings = 101.376;
		}
    elseif (($rows2[$j]['inventorySize'] == '13.2 gallons') && ($rows2[$j]['servingSize'] == '20 ounces')) {  // European/short 1/2 barrel, 20 ounce pours
          $num_servings = 84.48;
		}
    elseif (($rows2[$j]['inventorySize'] == '13.2 gallons') && ($rows2[$j]['servingSize'] == '16 ounces')) {  // European/short 1/2 barrel, 16 ounce pours
          $num_servings = 105.6;
		}
	elseif (($rows2[$j]['inventorySize'] == '13.2 gallons') && ($rows2[$j]['servingSize'] == '10 ounces')) {  // European/short 1/2 barrel, 10 ounce pours
          $num_servings = 168.96;
		}
    elseif (($rows2[$j]['inventorySize'] == '15.5 gallons') && ($rows2[$j]['servingSize'] == '16 ounces')) {  // American 1/2 barrel, 16 ounce pours
          $num_servings = 124;
		}
	elseif (($rows2[$j]['inventorySize'] == '15.5 gallons') && ($rows2[$j]['servingSize'] == '10 ounces')) {  // American 1/2 barrel, 10 ounce pours
          $num_servings = 198.4;
		}
	elseif (($rows[$j]['inventorySize'] == '24 bottles') && ($rows[$j]['servingSize'] == '12 ounces')) {  // case of 24 bottles
          $num_servings = 24;
		}
	elseif (($rows[$j]['inventorySize'] == '24 cans') && ($rows[$j]['servingSize'] == '12 ounces')) {  // case of 24 cans
          $num_servings = 24;
		}
	elseif (($rows[$j]['inventorySize'] == '24 cans') && ($rows[$j]['servingSize'] == '16 ounces')) {  // case of 24 cans
          $num_servings = 24;
		}
	elseif (($rows[$j]['inventorySize'] == '12 bottles') && ($rows[$j]['servingSize'] == '22 ounces')) {  // case of 12 bombers
          $num_servings = 12;
		}
	elseif (($rows[$j]['inventorySize'] == '12 bottles') && ($rows[$j]['servingSize'] == '12 ounces')) {  // case of 12 bottles - AMA Bionda is the only one I think
          $num_servings = 12;
		}
	elseif (($rows[$j]['inventorySize'] == '8 bottles') && ($rows[$j]['servingSize'] == '16.9 ounces')) {  // weirdo case of 8 bottles - Robinsons The Trooper is the only one I think
          $num_servings = 8;
		}
	elseif (($rows[$j]['inventorySize'] == '15 cans') && ($rows[$j]['servingSize'] == '12 ounces')) {  // weirdo case of 15 cans - Founders All Day IPA
          $num_servings = 15;
		}
    else {
        }
	array_push($rows2[$j],$num_servings); // this gets the value into the real main array, but without the proper key  // array position: [0] => $num_servings
        
	// determine our cost per serving
	$costPerServing = ($rows2[$j]['inventoryPrice'] / $num_servings);
    array_push($rows2[$j],$costPerServing); // this gets the value into the real main array, but without the proper key  // array position: [1] => $costPerServing

	// determine our profit per serving
	$profitPerServing = ($rows2[$j]['servingPrice'] - $costPerServing);
    array_push($rows2[$j],$profitPerServing); // this gets the value into the real main array, but without the proper key  // array position: [2] => $profitPerServing
	
	// determine our profit per serving if we sell for half price
	$profitPerServingEmployee = (($rows2[$j]['servingPrice'] / 2) - $costPerServing);
    array_push($rows2[$j],$profitPerServingEmployee); // this gets the value into the real main array, but without the proper key  // array position: [3] => $profitPerServingEmployee
	
	// calculate our profit percentage
	$profitPercentage = (($rows2[$j]['servingPrice'] / $costPerServing) * 100);
    array_push($rows2[$j],$profitPercentage); // this gets the value into the real main array, but without the proper key  // array position: [4] => $profitPercentage
	
}






for ($j = 0; $j < $mylength; $j++) {
	
	if ($rows2[$j]['BA_link'] == NULL) {  // if there isn't a beer advocate link, try the ratebeer link instead
          $rows2[$j]['BA_link'] = $rows2[$j]['RB_link'];
        }
	
	echo "<br /><a href=\"".$rows2[$j]['BA_link']."\" rel=\"external\">".$rows2[$j]['brand']." ".$rows2[$j]['type']."</a> (".number_format((float)($rows2[$j]['ABV']), 1, '.', '')."%)";
} 

?>