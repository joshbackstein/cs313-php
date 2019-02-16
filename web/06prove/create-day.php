<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/day-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['program_id']) || strlen($_POST['program_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['day_name']) || strlen($_POST['day_name']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['day_display_order']) || strlen($_POST['day_display_order']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    // Redirect to the program if one was provided
    if (isset($_POST['program_id']) && strlen($_POST['program_id']) > 0) {
      redirect('edit-program.php?program_id=' . $_POST['program_id']);
    }
    redirect('programs.php');
  }

  // Get the data
  $program_id = $_POST['program_id'];
  $name = $_POST['day_name'];
  $display_order = $_POST['day_display_order'];

  // Make sure this program actually belongs to the member
  if (!ownsProgram($program_id)) {
    require_once 'require/403.php';
  }

  // Create the day
  createDay($program_id, $name, $display_order);

  // Go back to the program editor
  redirect('edit-program.php?program_id=' . $program_id);
?>
