<?php
  // Make sure we're sending the correct response code
  http_response_code(404);

  // Default name for resource
  if ($resource_not_found == null) {
    $resource_not_found = 'Resource';
  }
?>
<!doctype html>
<html>
  <head>
    <title>404 Not Found</title>
  </head>
  <body>
    <?php
      echo '<h1>' . $resource_not_found . ' was not found</h1>';
    ?>
  </body>
</html>
<?php
  // This is the only code that needs to run and the only HTML
  // that needs to be displayed for the 404 page, so we can
  // kill any further execution
  exit();
?>
