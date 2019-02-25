<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/day-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure the day was provided
  $missing_data = false;
  if (!isset($_POST['program_id']) || strlen($_POST['program_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['day_id']) || strlen($_POST['day_id']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    if (isset($_POST['program_id']) && strlen($_POST['program_id']) > 0) {
      redirect('edit-program.php?program_id=' . $_POST['program_id']);
    }
    redirect('programs.php');
  }

  // Make sure the day actually belongs to the member
  $day_id = $_POST['day_id'];
  if (!ownsDay($day_id)) {
    require_once 'require/403.php';
  }

  // Delete day
  deleteDayByDayId($day_id);

  // Go back to the program editor
  $program_id = $_POST['program_id'];
  redirect('edit-program.php?program_id=' . $program_id);
?>
