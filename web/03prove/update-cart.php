<?php
  require('inc/session.php');
  require('inc/data.php');

  // Setting quantities and removing items from the cart
  // don't use JSON, so we need to check for them first.
  if (isset($_POST['action']) && isset($_POST['code'])) {
    $action = $_POST['action'];
    $code = $_POST['code'];

    if ($action == 'set' && isset($_POST['quantity'])) {
      // We should have received what quantity the user wants
      $quantity = $_POST['quantity'];

      // Set the quantity
      $_SESSION['cart'][$code] = $quantity;

      // Any non-positive number will remove it from the cart
      if ($_SESSION['cart'][$code] <= 0) {
        unset($_SESSION['cart'][$code]);
      }
    } elseif ($action == 'remove') {
      // Remove from cart
      unset($_SESSION['cart'][$code]);
    }

    // These requests don't get made through AJAX, so we need
    // to redirect the user back to the shopping cart
    header('Location: cart.php', true, 303);
    exit();
  }

  // If we've made it this far, we're receiving JSON for an
  // AJAX request

  // Decode JSON into an associative array
  $json = json_decode(file_get_contents('php://input'), true);

  // Get the action to be performed
  $action = $json['action'];

  // What should we do?
  if ($action == 'add') {
    // We should have received the product code and how many
    // to add to the cart
    $code = $json['code'];
    $num = $json['num'];

    // Get sum of existing quantity in cart and new quantity
    if (isset($_SESSION['cart'][$code])) {
      $num += $_SESSION['cart'][$code];
    }

    // Update cart with new quantity
    $_SESSION['cart'][$code] = $num;
  }

  echo json_encode(array('size' => getCartSize()));
?>
