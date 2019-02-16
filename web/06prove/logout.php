<?php
  // We have to start the session to access it to destroy it
  session_start();

  // To log the user out, we'll destroy the session
  session_destroy();

  // We have to manually clear the global session variables
  $_SESSION = array();

  // We have to manually clear the session cookie
  $params = session_get_cookie_params();
  setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));

  // We will generate a new session ID for good measure
  session_regenerate_id();

  // Redirect them to the login page
  header('Location: login.php', true, 303);
?>
