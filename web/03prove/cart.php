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
        <?php
          $cart = $_SESSION['cart'];

          if (empty($cart)) {
            echo '<div class="row cart">';
            echo '<div class="col text-center">';
            echo '<h1>Shopping cart is empty</h1>';
            echo '</div>';
            echo '</div>';
          } else {
            $total_order_price = 0;
            foreach ($cart as $product_code => $product_quantity) {
              echo '<div class="row row-eq-height cart">';

              // Display product thumbnail and name
              $product_name = $products[$product_code]['name'];
              $product_img_src = $products[$product_code]['img-src'];
              $product_img_alt = $products[$product_code]['img-alt'];
              echo '<div class="col-6 text-center">';
              echo '<div class="cart-thumbnail-container">';
              echo '<img alt="' . $product_img_alt . '" src="' . $product_img_src . '">';
              echo '</div>';
              echo '<div class="cart-name text-italic">';
              echo $product_name;
              echo '</div>';
              echo '</div>';

              // Display product price
              $product_price = $products[$product_code]['price'];
              echo '<div class="col-2 text-center">';
              echo '<div class="cart-price vert-mid-outer">';
              echo '<div class="vert-mid-inner">';
              echo '<span class="text-bold">Price:</span> $' . $product_price;
              echo '</div>';
              echo '</div>';
              echo '</div>';

              // Display product quantity
              echo '<div class="col-2 text-center">';
              echo '<div class="cart-quantity vert-mid-outer">';
              echo '<div class="vert-mid-inner">';
              echo '<form method="post" action="update-cart.php">';
              echo '<div>';
              echo '<span class="text-bold">Quantity:</span> <input name="quantity" type="text" value="' . $product_quantity . '">';
              echo '</div>';
              echo '<div>';
              echo '<input name="action" type="hidden" value="set">';
              echo '<input name="code" type="hidden" value="' . $product_code . '">';
              echo '<input class="btn btn-sm" type="submit" value="Set quantity">';
              echo '</div>';
              echo '</form>';
              echo '</div>';
              echo '</div>';
              echo '</div>';

              // Display total price for given quantity of product
              $product_total_price = $product_price * $product_quantity;
              echo '<div class="col-2 text-center">';
              echo '<div class="cart-total vert-mid-outer">';
              echo '<div class="vert-mid-inner">';
              echo '<div>';
              echo '<span class="text-bold">Total:</span> $' . $product_total_price;
              echo '</div>';
              echo '<div>';
              echo '<form method="post" action="update-cart.php">';
              echo '<input name="action" type="hidden" value="remove">';
              echo '<input name="code" type="hidden" value="' . $product_code . '">';
              echo '<input class="btn btn-sm" type="submit" value="Remove">';
              echo '</form>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';

              // End the row
              echo '</div>';

              // Add to total price for entire order
              $total_order_price += $product_total_price;
            }

            // Display total price for entire order
            echo '<div class="row row-eq-height cart">';
            echo '<div class="col-4 text-left">';
            echo '<div class="cart-total vert-mid-outer">';
            echo '<div class="vert-mid-inner">';
            echo '<div>';
            echo '<span class="text-bold">Order total:</span> $' . $total_order_price;
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-6 text-center">';
            echo '</div>';
            echo '<div class="col-2 text-center">';
            echo '<div class="vert-mid-outer">';
            echo '<div class="vert-mid-inner">';
            echo '<div>';
            echo '<a href="checkout.php"><button class="btn btn-sm">Proceed to checkout</button></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        ?>
      </div>
    </main>

    <footer>
      <?php require('inc/footer.php'); ?>
    </footer>

    <?php require('inc/bootstrap-body.php'); ?>
  </div>
  </body>
</html>
