<!-- Elements that are not code are Unindented for readability -->

<div id="resultDiv">
<!-- CSS -->
<link rel="stylesheet" href="./css/style.css">

<!-- PHP CODE -->
<?php
  // Helper functions
  function fnum($number) {
    return number_format($number, 2, '.', "");
  }
  
  // Code
  if(isset($_POST['submit']))
  {
    // COSTS
    // Size Costs
    $sizeCosts = [
      "small" => 3.00,
      "medium" => 5.00,
      "large" => 7.00
    ];
    // toppings extra costs, regular price for small and medium
    // 30% extra cost for large
    $toppingsValue = [
      "small" => 0,
      "medium" => 0,
      "large" => 0.30
    ];
    // Toppings Cost List
   $toppingCosts = [
      "sausage-patty" => 0.50,
      "vegetable-patty" => 0.50,
      "egg" => 0.50,
      "tomato" => 0.30,
      "red-onion" => 0.30,
      "lettuce" => 0.30,
      "cheese" => 0.50,
      "onion-ring" => 0.50,
      "hash-brown" => 0.50,
      "coleslaw" => 0.40,
      "ketchup" => 0.10,
      "mayo" => 0.10,
      "mustard" => 0.10,
      "bbq" => 0.10,
      "ranch" => 0.10
    ];
    // Size Names, for reciept charges
    $sizeNames = [
      "small" => "Small Size",
      "medium" => "Medium Size",
      "large" => "Large Size"
    ];
    // Toppings Names, for reciept charges
    $toppingNames = [
      "sausage-patty" => "Sausage Patty 🍖",
      "vegetable-patty" => "Vegetable Patty 🥦",
      "egg" => "Egg 🍳",
      "tomato" => "Tomato 🍅",
      "red-onion" => "Red Onion 🧅",
      "lettuce" => "Lettuce 🥬",
      "cheese" => "Cheese 🧀",
      "onion-ring" => "Onion Ring 🧅",
      "hash-brown" => "Hash Brown 🥔",
      "coleslaw" => "Coleslaw 🥗",
      "ketchup" => "Ketchup 🍅",
      "mayo" => "Mayonaise 🥪",
      "mustard" => "Mustard 🌭",
      "bbq" => "Barbeque Sauce 🔥",
      "ranch" => "Ranch 🥗"
    ];
    // Side orders and drinks costs
    $onionRingsCost = 5.00;
    $frenchFriesCost = 3.00;
    $waterCost = 1.00;
    $pepsiCost = 4.00;
    // TAX
    define("HST", 0.13);
    // Get Size
    $size = $_POST['size'];
    // Get Size Cost
    $sizeCost = $sizeCosts[$size];
    // Add Size Cost charge to reciept
    echo "+$" . fnum($sizeCost) . " [". $sizeNames[$size] ."]<br>";

    // Get Topping dropdown Amount
    $dropdownAmount = $_POST['amountOfToppings'];

    // Get Toppings in a list
    $toppings = [];
    for($i = 0; $i < $dropdownAmount; $i++) {
      $topping = $_POST['topping' . $i];
      if (array_key_exists($topping, $toppings)) {
        $toppings[$topping] += 1;
      } else {
        $toppings[$topping] = 1;
      };
    };

    $summedToppingsCost = 0.00;
    // uses a for loop to sum the cost of each topping
    for ($i = 0; $i < sizeof($toppings); $i++) {
      // Get topping Name
      $topping = array_keys($toppings)[$i];
      // Get cost of topping
      $toppingCost = $toppingCosts[$topping];
      // Get amount of topping
      $toppingAmount = $toppings[$topping];
      // multiply cost with amount to get total cost for topping
      $toppingCostTotal = $toppingCost * $toppingAmount;
      // Add it to the total topping cost sum
      $summedToppingsCost += $toppingCostTotal;

      // add charge to reciept
      echo "+$" . fnum($toppingCostTotal) . " [". $toppingNames[$topping] . " x" . $toppingAmount . "]<br>";
    };

    // Get Topping Premium [30% extra cost for large]
    $toppingPremium = $summedToppingsCost * $toppingsValue[$size];
    // Add the charge to the reciept
    echo "+$" . fnum($toppingPremium) . " [". $sizeNames[$size] . " Toppings additional cost]<br>";

    // Initialize variable to store summed cost for side-orders and drinks
    $summedSideOrderAndDrinksCost = 0.00;

    // Go through each side-order and drink
    // If ordered, add the total cost (amount*cost) to the summed cost
    // also, add the charge to the reciept
    
    // Onion Rings
    $onionRingsAmount = $_POST["onionRingsAmount"];
    if ($onionRingsAmount > 0) {
      $cost = $onionRingsAmount * $onionRingsCost;
      $summedSideOrderAndDrinksCost += $cost;
      echo "+$" . fnum($cost) . " [Onion Rings x". $onionRingsAmount . "]<br>";
    }

    // French Fries
    $frenchFriesAmount = $_POST["friesAmount"];
    if ($frenchFriesAmount > 0) {
      $cost = $frenchFriesAmount * $frenchFriesCost;
      $summedSideOrderAndDrinksCost += $cost;
      echo "+$" . fnum($cost) . " [French Fries x". $frenchFriesAmount . "]<br>";
    }

    // Water
    $waterAmount = $_POST["waterAmount"];
    if ($waterAmount > 0) {
      $cost = $waterAmount * $waterCost;
      $summedSideOrderAndDrinksCost += $cost;
      echo "+$" . fnum($cost) . " [Water 1000ml x". $waterAmount . "]<br>";
    }

    // Pepsi
    $pepsiAmount = $_POST["pepsiAmount"];
    if ($pepsiAmount > 0) {
      $cost = $pepsiAmount * $pepsiCost;
      $summedSideOrderAndDrinksCost += $cost;
      echo "+$" . fnum($cost) . " [Pepsi 500ml x". $pepsiAmount . "]<br>";
    }

    // Calculate subtotal, tax, and total
    $subtotal = $sizeCost + $summedToppingsCost + $toppingPremium + $summedSideOrderAndDrinksCost;
    $tax = $subtotal * HST;
    $total = $subtotal + $tax;

    // Add subtotal, tax, and total to the reciept
    echo "<b>Subtotal: $" . fnum($subtotal) . "</b><br>";
    echo "<b>Tax: $" . fnum($tax) ."</b><br>";
    echo "<b>Total: $" . fnum($total) . "</b><br>";
  }
  else {
    // Default
    echo "Results will be shown here...";
  };
?>
  
</div> 
