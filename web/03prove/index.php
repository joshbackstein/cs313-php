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
          $counter = 1;
          $num_products = count($products);
          foreach ($products as $product_code => $product) {
            // Each row will contain two columns. Every odd column will
            // be the start of a new row. This should work as long as
            // $counter starts at 1.
            if ($counter % 2 == 1) {
              echo '<div class="row row-eq-height justify-content-center">';
            }

            // Start product column
            echo '<div class="col-6 text-center">';
            echo '<div class="product">';

            // Display product name
            $product_name = $products[$product_code]['name'];
            echo '<div class="product-name">';
            echo '<h4>' . $product_name . '</h4>';
            echo '</div>';

            // Display product thumbnail
            $product_img_src = $products[$product_code]['img-src'];
            $product_img_alt = $products[$product_code]['img-alt'];
            echo '<div class="product-thumbnail-container">';
            echo '<img alt="' . $product_img_alt . '" src="' . $product_img_src . '">';
            echo '</div>';

            // Display product description
            $product_description = $products[$product_code]['description'];
            echo '<div class="product-description">';
            echo $product_description;
            echo '</div>';

            // Display product price
            $product_price = $products[$product_code]['price'];
            echo '<div class="product-price">';
            echo '<span class="text-bold">Price:</span> $' . $product_price;
            echo '</div>';

            // Display product quantity
            echo '<div class="product-quantity">';
            echo '<span class="text-bold">Quantity:</span> <input id="qty-' . $product_code . '" type="text" value="1">';
            echo '</div>';

            // Display button to add product to cart
            echo '<div class="product-add">';
            echo '<button class="btn btn-sm" onclick="addProduct(\'' . $product_code . '\')">Add to cart</button>';
            echo '</div>';

            // End product column
            echo '</div>';
            echo '</div>';

            // Every even column is the last column in the row, so we
            // need to close the row. In addition, if this is the last
            // column, we need to close the row. $counter should equal
            // $num_products at the end of the loop as long as $counter
            // starts at 1.
            if ($counter % 2 == 0 || $counter == $num_products) {
              echo '</div>';
            }

            // Increment the counter for the next product
            $counter += 1;
          }
        ?>
      </div>
    </main>

    <footer>
      <?php require('inc/footer.php'); ?>
    </footer>

    <?php require('inc/bootstrap-body.php'); ?>
    <script src="js/script.js"></script>
  </div>
  </body>
</html>
