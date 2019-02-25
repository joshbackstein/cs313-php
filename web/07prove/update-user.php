<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/admin-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['member_id']) || strlen($_POST['member_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['username']) || strlen($_POST['username']) < 1) {
    $missing_data = true;
  }
  // Blank passwords will update information without changing the password
  if (!isset($_POST['password'])) {
    $missing_data = true;
  }
  if (!isset($_POST['email']) || strlen($_POST['email']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['display_name']) || strlen($_POST['display_name']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    // Redirect to the member if one was provided
    if (isset($_POST['member_id']) && strlen($_POST['member_id']) > 0) {
      redirect('edit-user.php?member_id=' . $_POST['member_id']);
    }
    redirect('admin.php');
  }

  // Get data
  $member_id = $_POST['member_id'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $display_name = $_POST['display_name'];

  // A blank password will indicate that the password should not be changed
  $password_hash = null;
  if (strlen($_POST['password']) >= 1) {
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
  }

  // Only administrators can edit other members
  $current_member_id = getCurrentMemberId();
  if ($current_member_id != $member_id && !isAdmin($current_member_id)) {
    require_once 'require/403.php';
  }

  // Update the member
  updateMember($member_id, $username, $password_hash, $email, $display_name);

  // Go back to the admin portal
  redirect('admin.php');
?>
