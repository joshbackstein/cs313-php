<?php
  // This file should be included at the top of every page

  // Don't forget to start the session so users can use the cart
  session_start();

  // Initialize an empty cart if one does not yet exist
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }

  function getCartSize() {
    $sum = 0;
    foreach ($_SESSION['cart'] as $product => $quantity) {
      $sum += $quantity;
    }
    return $sum;
  }

  // Make a copy of the cart to use for reading back
  $cart = $_SESSION['cart'];
?>
