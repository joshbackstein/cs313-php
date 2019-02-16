<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/admin-func.php';
  require_once 'require/member-func.php';

  // Only admins can create members
  $current_member_id = getCurrentMemberId();
  if (!isAdmin($current_member_id)) {
    require_once 'require/403.php';
  }

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['username']) || strlen($_POST['username']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['password']) || strlen($_POST['password']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['email']) || strlen($_POST['email']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['display_name']) || strlen($_POST['display_name']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    redirect('admin.php');
  }

  // Create the member
  $username = $_POST['username'];
  $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $email = $_POST['email'];
  $display_name = $_POST['display_name'];
  createMember($username, $password_hash, $email, $display_name);

  // Return to admin portal
  redirect('admin.php');
?>
