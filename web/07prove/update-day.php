<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['day_id']) || strlen($_POST['day_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['day_name']) || strlen($_POST['day_name']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    // Redirect to the day if one was provided
    if (isset($_POST['day_id']) && strlen($_POST['day_id']) > 0) {
      redirect('edit-day.php?day_id=' . $_POST['day_id']);
    }
    redirect('programs.php');
  }

  // Get the data
  $day_id =$_POST['day_id'];
  $day_name =$_POST['day_name'];

  // Make sure this day actually belongs to the member
  if (!ownsDay($day_id)) {
    require_once 'require/403.php';
  }

  // Update the day
  updateDay($day_id, $day_name);

  // Go back to the day editor
  redirect('edit-day.php?day_id=' . $day_id);
?>
