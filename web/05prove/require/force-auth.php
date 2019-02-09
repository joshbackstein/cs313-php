<?php
  // This file should be included at the top of every page that requires
  // user authentication

  // We'll need a session
  require_once 'session.php';

  // Redirect unauthenticated users to the login page
  if (!isset($_SESSION['member_id'])) {
    header('Location: login.php', true, 303);
    exit();
  }

  // If user is authenticated, make their data easier to access
  $member_id = $_SESSION['member_id'];
  $username = $_SESSION['username'];
  $email = htmlspecialchars($_SESSION['email']);
  $display_name = htmlspecialchars($_SESSION['display_name']);
?>
