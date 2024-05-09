/*
* Created by: Atri Sarker
* Created on: May, 2024
* Description: This file contains the input.js for the Burger Palace website. This script is in charge of managing the topping dropwdowns and the sandwich display.
*/
'use strict'; // Strict mode

// Get container for the topping dropdowns
const toppingsDiv = document.getElementById('toppingsContainer');

// Get the amount of toppings Input element
const amountOfToppingsInput = document.getElementById('amountOfToppings');

// Get the topping dropdown template
let toppingDivOriginal = document.getElementById('toppingTemplate');
// Clone it and save the template inside a constant for later use
const toppingDivTemplate = toppingDivOriginal.cloneNode(true);
// Remove the original template from the webpage
toppingDivOriginal.remove();

// Helper Function to get child from a parent
// Returns the first child that matches the elementType
function getChild(parent, elementType) {
  // Get children
  let children = parent.childNodes;
  // Loop through children
  for (let i = 0; i < children.length; i++) {
    // If child matches the elementType, return it
    if (children[i].nodeName.toLowerCase() == elementType) {
      return children[i];
    }
  }
  // If no child matched, returns null
  return null;
}

// Function that creates a clone of the topping dropdown template
function newTopping() {
  return toppingDivTemplate.cloneNode(true);
}

// Function that adds a topping dropdown to the topping drowpdown container div
function addTopping(toppingName, pos = "default") {

  // Default parameter, position gets set at the end of the dropdowns
  // Note: Originally it was made like this so I could do drag and drop functionality by setting the positions through the function
  // I never used a pos other than "default" since I scrapped the drag and drop feature
  if (pos == "default") {
    pos = toppingsContainer.childNodes.length;
  }

  // New Topping Dropdown, Clone of the template
  let topping = newTopping();
  // let topping = newTopping();

  // Get the <select> element
  let dropdownList = getChild(topping, "select");

  // Add the new topping element to the topping dropdown container
  toppingsContainer.appendChild(topping);

  // Set the selected value to the provided topping
  dropdownList.value = toppingName;
  // Set the id to include the position of the topping
  // redundant since I scrapped the drag and drop feature
  dropdownList.id = `topping${pos}`

  // Connect dropwdown value change to the drawSandwich function 
  // located at [bottom of the script file]
  dropdownList.addEventListener('change', drawSandwich);
}

// Connect the amount of toppings input to the amount of dropdowns present
amountOfToppingsInput.oninput = () => {
  // Get the input
  let amount = Number(amountOfToppingsInput.value);
  // Get max amount
  let maxAmount = Number(amountOfToppingsInput.getAttribute("max"));

  if (amount > maxAmount) {
    // If the amount is greater than the max amount, set the amount to the max amount
    // Prevents the user from entering more toppings than the max amount
    amount = maxAmount;
    amountOfToppingsInput.value = amount;
  }
  else if (amount < 0) {
    // Prevents negative input by always keeping it at a non-negative value
    amount = 0;
    amountOfToppingsInput.value = amount;
  }
  else if ( amount % 1 != 0 ) {
    // Prevents non-integer input by always keeping it at an integer value
    amount = Math.floor(amount);
    amountOfToppingsInput.value = amount;
  }

  // Current list of children of the toppings container
  let current = toppingsContainer.childNodes;

  // Current amount of topping dropdowns, substracted by 2 to account for the 2 non-dropdown children inside the toppings container
  let currentAmount = current.length - 2;

  if (currentAmount == amount) {
    // If input is equal to the current amount, do nothing
    // amount of dropdowns will stay the same
    return;
  }

  if (currentAmount < amount) {
    // If input is greater than the current amount
    // Then : add more dropdowns till the amount reaches the input
    for (let i=currentAmount; i < amount; i++) {
      // Adds a dropdown, defaulted value of sausage-patty
      addTopping('sausage-patty');
    }
  }
  else {
    // If input is less than the current amount
    // Then : remove dropdowns until the amount reaches the input
    for (let i=currentAmount; i > amount; i--) {
      // Deletes the bottom-most dropdown
      toppingsContainer.lastChild.remove();
    }
  }

  // Draw the sandwich, this function is located at the bottom of the script file
  // This is done to display the sandwich with the newly added toppings from the dropwdowns.
  drawSandwich();
}


// DISPLAY SANDWICH CODE

// Get the canvas element for displaying the sandwich
const sandwichDisplay = document.getElementById('sandwichDisplay');

// Get the render/draw element for the canvas
const render = sandwichDisplay.getContext('2d');

// FILEPATH FOR TOPPING IMAGES
const imagePath = './.././images/toppings/';

// function that gets image using filepath and name/value
function image(toppingName) {
  let img = new Image();
  img.src = imagePath + toppingName + '.png';
  return img
}

// Variable that keeps track of the current display
let version = 0;

// function that draws and displays the sandwich
function drawSandwich() {

  // New version, prevents unwanted draws from previous versions
  version += 1;
  let currentVersion = version;

  // Clear canvas
  render.clearRect(0, 0, sandwichDisplay.width, sandwichDisplay.height);

  // List to contain the toppings
  let toppingList = []

  // Add "top-bagel" to list
  toppingList.push("top-bagel")

  // Get all dropdowns using queryselector order[top-bottom]
  let toppingDropdowns = document.querySelectorAll('select');
  // Loop through all selections and add them to the list
  for (let i = 0; i < toppingDropdowns.length; i++) {
    let topping = toppingDropdowns[i].value;
    toppingList.push(topping);
  }
  // Add "bottom-bagel" to list
  toppingList.push("bottom-bagel")

  // reverse the list, as drawing will be done from bottom to top, 
  // starting from "bottom-bagel"
  toppingList.reverse();

  // Resize canvas to fit sandwich (27px per topping)
  sandwichDisplay.height = 27 * (toppingList.length+1)

  // Get canvas width and height
  let canvasWidth = sandwichDisplay.width;
  let canvasHeight = sandwichDisplay.height;

  // Calculate the Dimensions for the topping Images

  // Height
  let toppingHeight = (canvasHeight) / (1+ toppingList.length*0.25);
  // Width, Math.min to prevent width from surpassing canvas width
  let toppingWidth = Math.min(canvasWidth,toppingHeight * 1.8);

  // Images are drawn from their top-left postion
  // drawX ensures the image is drawn in the middle of the canvas x-axis
  let drawX = canvasWidth / 2 - toppingWidth / 2;

  // Recursion function to draw the toppings
  // Recursion is used so that the image draw order will be proper
  // A topping would only be drawn when the previous topping finishes loading.
  // vice-versa for future toppings, until all toppings are drawn
  let drawTopping = (zIndex) => {

    if (zIndex >= toppingList.length ) {
      // Escape condtion, returns once all toppings are drawn
      return
    }
    if (currentVersion != version) {
      // Stops the drawing if a new drawing/display has started
      return
    }

    // Get the topping name/value
    let toppingName = toppingList[zIndex];
    // Get the topping's image using the topping name/value
    let img = image(toppingName);

    // Connect onload to draw function, to ensure the image is loaded before drawing
    img.onload = () => {
      // get drawY
      let drawY = canvasHeight - toppingHeight * (zIndex/4 + 1)
      // Draws the image
      render.drawImage(img, drawX, drawY, toppingWidth, toppingHeight);
      // Draw the next topping on top of this topping, recursion
      drawTopping(zIndex + 1);
    }
  }

  // Draw the first topping, will always be "bottom-bagel"
  drawTopping(0);

  return;
}


// Default Initial sandwich
addTopping('sausage-patty');
addTopping('cheese');
addTopping('egg');

// Initial Draw for the default sandwich
drawSandwich();

