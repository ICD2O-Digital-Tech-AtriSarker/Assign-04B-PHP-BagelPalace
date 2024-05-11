<!DOCTYPE html>
<html>
  <!--
    * Created by: Atri Sarker
    * Created on: April, 2024
    * Description: This file contains the index.php for the Burger Palace Website.
  -->

<head>
  <!-- Metadata -->
  <meta charset="utf-8">
  <meta name="description" content="Bagel Palace Food Order, Using PHP">
  <meta name="keywords" content="immaculata, icd2o">
  <meta name="author" content="Atri Sarker">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="./fav_index/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./fav_index/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./fav_index/favicon-16x16.png">
  <link rel="manifest" href="./fav_index/site.webmanifest">

  <!-- MDL -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="./css/style.css">

  <!-- Title -->
  <title>Bagel Palace in PHP</title>
</head>

<body>

  <!-- Script for dropdown inputs and sandwich display -->
  <script defer src="./js/input.js"></script>

  <!-- Header -->
  <h1>🥯Bagel Palace in PHP</h1>

  <!-- FORM -->
  <form id="inputForm" method="post" action="results.php" target="resultFrame">
    <div>
      <!-- Size Selection -->
      <!-- Header for Size selection -->
      <h3>Pick Size</h3>

      <!-- Radio Buttons | Options : ["Small","Medium","Large"] -->
      <div>
        <!-- Small -->
        <div class="radioDiv">
          <input type="radio" id="small" name="size" value="small">
          <label for="small">Small</label>
        </div>
        <!-- Medium -->
        <div class="radioDiv">
          <input type="radio" checked="checked" id="medium" name="size" value="medium">
          <label for="medium">Medium</label>
        </div>
        <!-- Large -->
        <div class="radioDiv">
          <input type="radio" id="large" name="size" value="large">
          <label for="large">Large</label>
        </div>
      </div>

      <!-- Header for Topping selection -->
      <h3>Toppings</h3>
      <!-- Input for amount of toppings -->
      <!-- Automatically creates topping dropwdowns based on the input -->
      <label>Enter Amount Of Toppings (99 Max):</label>
      <input id="amountOfToppings" name="amountOfToppings" type="number" min="0" step="1" max="99" value="3">

      <!-- Table for Layout, dropdowns on left side; sandwich display on right side -->
      <table><tr>

      <!-- Column for topping dropdowns -->
      <td id="toppingsContainer">
        <!-- Topping Dropdown Template -->
        <div id="toppingTemplate">
          <select selected="egg">
            <optgroup label="Proteins">
              <option value="sausage-patty">Sausage Patty 🍖</option>
              <option value="vegetable-patty">Vegetable Patty 🥦</option>
              <option value="egg">Egg 🍳</option>
            </optgroup>
            <optgroup label="Veggies">
              <option value="tomato">Tomato 🍅</option>
              <option value="red-onion">Red Onion 🧅</option>
              <option value="lettuce">Lettuce 🥬</option>
            </optgroup>
            <optgroup label="Extra">
              <option value="cheese">Cheese 🧀</option>
              <option value="onion-ring">Onion Ring 🧅</option>
              <option value="hash-brown">Hash Brown 🥔</option>
              <option value="coleslaw">Coleslaw 🥗</option>
            </optgroup>
            <optgroup label="Sauces and Dressings">
              <option value="ketchup">Ketchup 🍅</option>
              <option value="mayo">Mayonnaise 🥪</option>
              <option value="mustard">Mustard 🌭</option>
              <option value="bbq">Barbeque Sauce 🔥</option>
              <option value="ranch">Ranch 🥗</option>
            </optgroup>
          </select>
        </div>
      </td>
      <td>
        <canvas id="sandwichDisplay"></canvas>
      </td>
      </tr></table>

      <!-- Sides orders and Drinks -->
      <!-- Onion Rings -->
      <div class="mini-order side-order">
        <img src="./images/onionRings.png" alt="Onion Rings">
        <p>Onion Rings</p>
        <div>
          <button type="button" onclick="this.parentNode.querySelector('input').stepDown()">-</button>
          <input type="number" name="onionRingsAmount" id="onionRingsAmount" min="0" max="99" value="0">
          <button type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
        </div>
      </div>
      <!-- Fries -->
      <div class="mini-order side-order">
        <img src="./images/frenchFries.png" alt="French Fries">
        <p>Fries</p>
        <div>
          <button type="button" onclick="this.parentNode.querySelector('input').stepDown()">-</button>
          <input type="number" name="friesAmount" id="friesAmount" min="0" max="99" value="0">
          <button type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
        </div>
      </div>
      <!-- Water -->
      <div class="mini-order drink-order">
        <img src="./images/water.png" alt="Water">
        <p>Water (1000ml)</p>
        <div>
          <button type="button" onclick="this.parentNode.querySelector('input').stepDown()">-</button>
          <input type="number" name="waterAmount" id="waterAmount" min="0" max="99" value="0">
          <button type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
        </div>
      </div>
      <!-- Pepsi -->
      <div class="mini-order drink-order">
        <img src="./images/pepsi.png" alt="Pepsi">
        <p>Pepsi (500ml)</p>
        <div>
          <button type="button" onclick="this.parentNode.querySelector('input').stepDown()">-</button>
          <input type="number" name="pepsiAmount" id="pepsiAmount" min="0" max="99" value="0">
          <button type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
        </div>
      </div>

      <br>

      <!-- Results Button -->
      <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name="submit" value="Get Result!" id="resultBtn">


  </form>

  <!-- Result -->
  <iframe name="resultFrame" src="./results.php">
  </iframe>

</body>

</html>