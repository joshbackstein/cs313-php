<?php
  // Catch errors
  $password_mismatch = false;
  if (isset($_GET['password_mismatch']) && $_GET['password_mismatch'] == 1) {
    $password_mismatch = true;
  }
  $password_too_short = false;
  if (isset($_GET['password_too_short']) && $_GET['password_too_short'] == 1) {
    $password_too_short = true;
  }
  $password_needs_number = false;
  if (isset($_GET['password_needs_number']) && $_GET['password_needs_number'] == 1) {
    $password_needs_number = true;
  }

  // Figure out if we need to display asterisks
  $password_error = false;
  if ($password_mismatch || $password_too_short || $password_needs_number) {
    $password_error = true;
  }

  $error_mismatch = '';
  if (!$password_mismatch) {
    $error_mismatch = 'hidden';
  }
  $error_too_short = '';
  if (!$password_too_short) {
    $error_too_short = 'hidden';
  }
  $error_needs_number = '';
  if (!$password_needs_number) {
    $error_needs_number = 'hidden';
  }
  $error_password = '';
  if (!$password_error) {
    $error_password = 'hidden';
  }
?>
<!doctype>
<html>
  <head>
    <title>07 Teach - Sign Up</title>
    <style>
      .error {
        color: red;
      }
      .hidden {
        display: none;
      }
    </style>
  </head>
  <body>
    <div class="error">
      <?php
        echo '<div id="error-password-mismatch"';
        echo ' class="' . $error_mismatch . '">';
        echo '<p>Passwords must match</p>';
        echo '</div>';

        echo '<div id="error-password-too-short"';
        echo ' class="' . $error_too_short . '">';
        echo '<p>Password must be at least seven characters long</p>';
        echo '</div>';

        echo '<div id="error-password-needs-number"';
        echo ' class="' . $error_needs_number . '">';
        echo '<p>Password must contain at least one number</p>';
        echo '</div>';
      ?>
    </div>
    <form action="create-user.php" method="post">
      <input type="text" name="username" placeholder="Enter username" required autofocus><br>
      <input id="password-a" type="password" name="password_a" placeholder="Enter password" oninput="passwordUpdate()" required>
      <?php
        echo '<span class="error">';
        echo '<span id="error-password"';
        echo ' class="' . $error_password . '">';
        echo '&ast;';
        echo '</span>';
        echo '</span>';
      ?>
      <br>
      <input id="password-b" type="password" name="password_b" placeholder="Confirm password" oninput="passwordUpdate()" required>
      <?php
        echo '<span class="error">';
        echo '<span id="error-password-confirm"';
        echo ' class="' . $error_password . '">';
        echo '&ast;';
        echo '</span>';
        echo '</span>';
      ?>
      <br>
      <input type="submit" value="Sign Up">
    </form>
    <div>
      <a href="login.php">Log In</a>
    </div>

    <script>
      passwordUpdate = function() {
        var a = document.getElementById("password-a").value;
        var b = document.getElementById("password-b").value;
        var errExists = false;
        if (a == b) {
          var err = document.getElementById("error-password-mismatch");
          err.classList.add("hidden");
        } else {
          var err = document.getElementById("error-password-mismatch");
          err.classList.remove("hidden");
          errExists = true;
        }
        if (a.length >= 7) {
          var err = document.getElementById("error-password-too-short");
          err.classList.add("hidden");
        } else {
          var err = document.getElementById("error-password-too-short");
          err.classList.remove("hidden");
          errExists = true;
        }
        if (a.match(/\d/) != null) {
          var err = document.getElementById("error-password-needs-number");
          err.classList.add("hidden");
        } else {
          var err = document.getElementById("error-password-needs-number");
          err.classList.remove("hidden");
          errExists = true;
        }
        if (!errExists) {
          var errA = document.getElementById("error-password");
          var errB = document.getElementById("error-password-confirm");
          errA.classList.add("hidden");
          errB.classList.add("hidden");
        } else {
          var errA = document.getElementById("error-password");
          var errB = document.getElementById("error-password-confirm");
          errA.classList.remove("hidden");
          errB.classList.remove("hidden");
        }
      }
    </script>
  </body>
</html>
