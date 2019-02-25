<?php
  require_once 'session.php';

  // We'll need access to the database
  require_once 'db.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['username']) || strlen($_POST['username']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['password']) || strlen($_POST['password']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    header('Location: login.php');
    exit();
  }

  // Extract data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate user
  $db = getDb();
  $qry = 'SELECT member_id, password_hash FROM member_teach_07 WHERE username = :u';
  $stmt = $db->prepare($qry);
  $stmt->bindValue(':u', $username, PDO::PARAM_STR);
  $stmt->execute();
  $member = $stmt->fetch(PDO::FETCH_ASSOC);
  $member_id = $member['member_id'];
  $password_hash = $member['password_hash'];
  $valid_credentials = password_verify($password, $password_hash);

  // If the credentials were invalid, the user will need to try
  // to login again
  if (!$valid_credentials) {
    header('Location: login.php?invalid_credentials=1');
    exit();
  }

  // Log user in
  $_SESSION['member_id'] = $member_id;
  header('Location: welcome.php');
  exit();
?>
