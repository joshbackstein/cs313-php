<?php
  // We'll need access to the database
  require_once 'db.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['username']) || strlen($_POST['username']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['password_a']) || strlen($_POST['password_a']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    header('Location: sign-up.php');
    exit();
  }

  // Make sure the passwords match
  if ($_POST['password_a'] != $_POST['password_b']) {
    header('Location: sign-up.php?password_mismatch=1');
    exit();
  }

  // Make sure password has a minimum of 7 characters
  // and at least 1 number
  if (strlen($_POST['password_a']) < 7) {
    header('Location: sign-up.php?password_too_short=1');
    exit();
  }
  if (preg_match('/\d/', $_POST['password_a']) == 0) {
    header('Location: sign-up.php?password_needs_number=1');
    exit();
  }

  // Extract data
  $username = $_POST['username'];
  $password_hash = password_hash($_POST['password_a'], PASSWORD_BCRYPT);

  // Create user
  $db = getDb();
  $qry = 'INSERT INTO member_teach_07 (username, password_hash) VALUES (:u, :p)';
  $stmt = $db->prepare($qry);
  $stmt->bindValue(':u', $username, PDO::PARAM_STR);
  $stmt->bindValue(':p', $password_hash, PDO::PARAM_STR);
  $stmt->execute();

  // Go to the login page
  header('Location: login.php');
  exit();
?>
