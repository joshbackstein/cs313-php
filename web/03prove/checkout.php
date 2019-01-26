<?php
  require('inc/session.php');
  require('inc/data.php');
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
        <form method="post" action="confirm.php">
          <div class="row row-eq-height checkout">
            <div class="col-7">
              <?php
                $cart = $_SESSION['cart'];

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
                    echo '<div class="col-6 text-left">';
                    echo '<span class="text-bold">Product:</span> ' . $product_name;
                    echo '</div>';

                    // Display product quantity
                    echo '<div class="col-3 text-left">';
                    echo '<span class="text-bold">Quantity:</span> ' . $product_quantity;
                    echo '</div>';

                    // Display total price for given quantity of product
                    $product_price = $products[$product_code]['price'];
                    $product_total_price = $product_price * $product_quantity;
                    echo '<div class="col-3 text-left">';
                    echo '<span class="text-bold">Total:</span> $' . $product_total_price;
                    echo '</div>';

                    // End the row
                    echo '</div>';

                    // Add to total price for entire order
                    $total_order_price += $product_total_price;
                  }
                }
              ?>
            </div>
            <div class="col-5">
              <div class="row">
                <div class="col-6 text-right">
                  <p>Name:</p>
                  <p>Address Line 1:</p>
                  <p>Address Line 2:</p>
                  <p>City:</p>
                  <p>State:</p>
                  <p>Zip Code:</p>
                </div>
                <div class="col-6 text-left">
                  <p><input type="text" name="name" placeholder="Required"></p>
                  <p><input type="text" name="line1" placeholder="Required"></p>
                  <p><input type="text" name="line2" placeholder="Optional"></p>
                  <p><input type="text" name="city" placeholder="Required"></p>
                  <p><input type="text" name="state" placeholder="Required"></p>
                  <p><input type="text" name="zip" placeholder="Required"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row row-eq-height checkout">
            <div class="col-4 text-left">
              <a href="cart.php"><input class="btn btn-sm" type="button" value="Back to cart"></a>
            </div>
            <div class="col-4 text-center">
              <div class="cart-total vert-mid-outer">
                <div class="vert-mid-inner">
                  <div>
                    <span class="text-bold">Order total:</span> $<?php echo $total_order_price; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4 text-right">
              <input class="btn btn-sm" type="submit" value="Checkout">
            </div>
          </div>
        </form>
      </div>
    </main>

    <footer>
      <?php require('inc/footer.php'); ?>
    </footer>

    <?php require('inc/bootstrap-body.php'); ?>
  </div>
  </body>
</html>
