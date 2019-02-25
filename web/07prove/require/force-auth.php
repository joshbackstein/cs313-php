<?php
  // This file should be included at the top of every page that requires
  // user authentication

  // We'll need a session
  require_once 'session.php';

  // We'll need some functions
  require_once 'helper-func.php';
  require_once 'member-func.php';

  // Redirect unauthenticated users to the login page
  if (!isset($_SESSION['member_id'])) {
    redirect('login.php', 303);
  }

  // Otherwise, we'll refresh the session variables
  refreshMemberSession($_SESSION['member_id']);
?>
