<?php
  require('inc/session.php');
  require('inc/data.php');

  // Make sure all information was supplied
  $is_missing_info = false;
  if (!isset($_POST['name'])) {
    $is_missing_info = true;
  }
  if (!isset($_POST['line1'])) {
    $is_missing_info = true;
  }
  // Line 2 is not required
  if (!isset($_POST['city'])) {
    $is_missing_info = true;
  }
  if (!isset($_POST['state'])) {
    $is_missing_info = true;
  }
  if (!isset($_POST['zip'])) {
    $is_missing_info = true;
  }
  if ($is_missing_info) {
    header('Location: checkout.php', true, 303);
    exit();
  }

  // If we've made it this far, we've received stuff,
  // but we still need to make sure it actually contains
  // something
  $name = htmlspecialchars($_POST['name']);
  $line1 = htmlspecialchars($_POST['line1']);
  $line2 = '';
  if (isset($_POST['line2'])) {
    $line2 = htmlspecialchars($_POST['line2']);
  }
  $city = htmlspecialchars($_POST['city']);
  $state = htmlspecialchars($_POST['state']);
  $zip = htmlspecialchars($_POST['zip']);
  if (strlen($name) <= 0) {
    $is_missing_info = true;
  }
  if (strlen($line1) <= 0) {
    $is_missing_info = true;
  }
  // Line 2 is not required
  if (strlen($city) <= 0) {
    $is_missing_info = true;
  }
  if (strlen($state) <= 0) {
    $is_missing_info = true;
  }
  if (strlen($zip) <= 0) {
    $is_missing_info = true;
  }
  if ($is_missing_info) {
    header('Location: checkout.php', true, 303);
    exit();
  }

  // If we've made it this far, we were passed
  // good data. At this point, we can confirm
  // the order and clear the cart.
  unset($_SESSION['cart']);
?>
<!doctype html>
<html>
  <head>
    <?php
      require('inc/bootstrap-head.php');
      require('inc/head.php');
    ?>
  </head>
  <body>
    <div id="complete-page-container">
    <header>
      <?php require('inc/nav.php'); ?>
    </header>

    <main>
      <div class="container">
        <div class="row checkout">
          <div class="col">
            <?php
              if (empty($cart)) {
                // Empty carts can't be checked out
                header('Location: cart.php', true, 303);
                exit();
              } else {
                $total_order_price = 0;
                foreach ($cart as $product_code => $product_quantity) {
                  echo '<div class="row">';

                  // Display product thumbnail and name
                  $product_name = $products[$product_code]['name'];
                  echo '<div class="col-8 text-left">';
                  echo '<span class="text-bold">Product:</span> ' . $product_name;
                  echo '</div>';

                  // Display product quantity
                  echo '<div class="col-2 text-left">';
                  echo '<span class="text-bold">Quantity:</span> ' . $product_quantity;
                  echo '</div>';

                  // Display total price for given quantity of product
                  $product_price = $products[$product_code]['price'];
                  $product_total_price = $product_price * $product_quantity;
                  echo '<div class="col-2 text-left">';
                  echo '<span class="text-bold">Total:</span> $' . $product_total_price;
                  echo '</div>';

                  // End the row
                  echo '</div>';

                  // Add to total price for entire order
                  $total_order_price += $product_total_price;
                }
              }
            ?>
            <div class="row pad-top">
              <div class="col-2 text-left">
                <span class="text-bold">Shipping to:</span>
              </div>
              <div class="col-4 text-left">
                <?php
                  echo '<div>' . $name . '</div>';
                  echo '<div>' . $line1 . '</div>';
                  if (isset($line2) && strlen($line2) > 0) {
                    echo '<div>' . $line2 . '</div>';
                  }
                  echo '<div>' . $city . ', ' .  $state . ' ' . $zip . '</div>';
                ?>
              </div>
              <div class="col-2">
              </div>
              <div class="col-4 text-left">
                <span class="text-bold">Order total:</span> $<?php echo $total_order_price; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row row-eq-height checkout">
          <div class="col text-center">
            <a href="index.php"><button class="btn btn-sm">Keep shopping</button></a>
          </div>
        </div>
      </div>
    </main>

    <footer>
      <?php require('inc/footer.php'); ?>
    </footer>

    <?php require('inc/bootstrap-body.php'); ?>
  </div>
  </body>
</html>
