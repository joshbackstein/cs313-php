<?php
  // Make sure we're sending the correct response code
  http_response_code(403);
?>
<!doctype html>
<html>
  <head>
    <title>403 Forbidden</title>
  </head>
  <body>
    403 Forbidden
  </body>
</html>
<?php
  // This is the only code that needs to run and the only HTML
  // that needs to be displayed for the 403 page, so we can
  // kill any further execution
  exit();
?>
