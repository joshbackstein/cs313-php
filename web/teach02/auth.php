<?php
  require('session.php');

  if (isset($_GET['user'])) {
    // Logging in, so set session variable
    $_SESSION['user'] = $_GET['user'];
  }
  if (isset($_GET['logout'])) {
    // Logging out, so unset session variables
    session_unset();
  }

  // Redirect to home page
  header('Location: home.php', true, 303);
  exit();
?>
