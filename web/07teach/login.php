<?php
  $invalid_credentials = false;
  if (isset($_GET['invalid_credentials']) && $_GET['invalid_credentials'] == 1) {
    $invalid_credentials = true;
  }
?>
<!doctype>
<html>
  <head>
    <title>07 Teach - Login</title>
    <style>
      .error {
        color: red;
      }
    </style>
  </head>
  <body>
    <div class="error">
      <?php
        if ($invalid_credentials) {
          echo '<p>Error: Invalid credentials</p>';
        }
      ?>
    </div>
    <form action="auth.php" method="post">
      <input type="text" name="username" placeholder="Enter username" required autofocus><br>
      <input type="password" name="password" placeholder="Enter password" required><br>
      <input type="submit" value="Log In">
    </form>
    <div>
      <a href="sign-up.php">Sign Up</a>
    </div>
  </body>
</html>
