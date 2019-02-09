<?php
  // We'll need a session
  require_once 'session.php';

  // Log user in
  function attemptLogin($db, $username, $password) {
    // Make sure both a username and password were passed
    if ($username == null) {
      return 'Please enter a username';
    }
    if ($password == null) {
      return 'Please enter a password';
    }

    // Username and password were both provided, so get information
    // about user from the database
    $columns = [
      'member_id',
      'username',
      'password_hash',
      'email',
      'display_name',
    ];
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM member WHERE username = :username';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Check if the user actually exists
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) < 1) {
      return 'User does not exist: ' . htmlspecialchars($username);
    }

    // Only one row will be returned, so we know
    // we can grab it at index 0
    $row = $rows[0];

    // Check for invalid password
    $password_hash = $row['password_hash'];
    if (!password_verify($password, $password_hash)) {
      return 'Invalid password';
    }

    // The user exists and the password is correct, so add the
    // user information to the session
    $_SESSION['member_id'] = $row['member_id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['display_name'] = $row['display_name'];

    // Explicitly returning null, which indicates the login was
    // successful
    return null;
  }
?>
