<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/admin-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure current user is an admin
  $current_member_id = getCurrentMemberId();
  if (!isAdmin($current_member_id)) {
    require_once 'require/403.php';
  }

  // Make sure a member was passed
  if (!isset($_POST['member_id'])) {
    redirect('admin.php');
  }

  // Make sure the member actually exists
  $member_id = $_POST['member_id'];
  if (!memberExists($member_id)) {
    $resource_not_found = 'Member';
    require_once 'require/404.php';
  }

  // Don't delete admins
  if (isAdmin($member_id)) {
    redirect('admin.php');
  }

  // Delete member
  deleteMemberByMemberId($member_id);

  // Return to admin portal
  redirect('admin.php');
?>
