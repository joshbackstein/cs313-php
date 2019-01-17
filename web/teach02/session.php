<?php
  // This file should be included at the top of every page

  // Don't forget to start the session so users can login
  session_start();

  // Set globals to make it easy to see who is logged in
  if ($_SESSION['user'] == 'administrator') {
    $GLOBALS['is_administrator'] = true;

    // Can't be logged in as both
    $GLOBALS['is_tester'] = false;
  } elseif ($_SESSION['user'] == 'tester') {
    $GLOBALS['is_tester'] = true;

    // Can't be logged in as both
    $GLOBALS['is_administrator'] = false;
  } else {
    $GLOBALS['is_administrator'] = false;
    $GLOBALS['is_tester'] = false;
  }
?>
