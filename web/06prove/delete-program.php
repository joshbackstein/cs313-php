<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['program_id']) || strlen($_POST['program_id']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    redirect('programs.php');
  }

  // Make sure the program actually belongs to the current member
  $program_id = $_POST['program_id'];
  if (!ownsProgram($program_id)) {
    require_once 'require/403.php';
  }

  // Delete program
  deleteProgramByProgramId($program_id);

  // Go back to program manager
  redirect('programs.php');
?>
