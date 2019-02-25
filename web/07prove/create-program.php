<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';
  require_once 'require/program-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['program_name']) || strlen($_POST['program_name']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    redirect('programs.php');
  }

  // Get member ID so we can create a program
  $member_id = getCurrentMemberId();

  // Create the program
  $name = $_POST['program_name'];
  createProgram($member_id, $name);

  // Go back to program manager
  redirect('programs.php');
?>
