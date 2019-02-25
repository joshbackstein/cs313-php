<?php
  // We'll need a session
  require_once 'require/session.php';

  // We'll need database access
  require_once 'require/db.php';

  // We'll need some functions
  require_once 'require/login-func.php';

  // We'll need a title
  $title = 'Login';

  // Attempt to log user in if username and password were provided
  $error_message = null;
  if (isset($_POST['submit'])) {
    $error_message = attemptLogin($_POST['username'], $_POST['password']);
  }

  // If the user is logged in, redirect them to the index
  if (isset($_SESSION['member_id'])) {
    header('Location: index.php', true, 303);
    exit();
  }
?>
<!doctype html>
<html>
  <head>
    <?php require 'require/bootstrap-head.php'; ?>
    <?php require 'require/template-head.php'; ?>
  </head>
  <body class="text-center d-flex">
    <form class="login" method="POST" action="login.php">
      <h1 class="h3 mb-3 font-weight-normal">Login</h1>
      <?php
        if ($error_message != null) {
          echo '<div>' . $error_message . '</div>';
        }
      ?>
      <div class="login-input-container">
        <input name="username" type="text" class="form-control" placeholder="Username" required autofocus>
      </div>
      <div class="login-input-container">
        <input name="password" type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="login-input-container">
        <input name="submit" type="submit" class="btn btn-lg btn-dark btn-block" value="Submit">
      </div>
    </form>

    <?php require 'require/bootstrap-foot.php'; ?>
  </body>
</html>
