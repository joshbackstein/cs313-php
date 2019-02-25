<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['exercise_name']) || strlen($_POST['exercise_name']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['exercise_description']) || strlen($_POST['exercise_description']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    redirect('exercises.php');
  }

  // Get member ID so we can create an exercise
  $member_id = getCurrentMemberId();

  // Create the exercise
  $name = $_POST['exercise_name'];
  $description = $_POST['exercise_description'];
  createExercise($member_id, $name, $description);

  // Go back to exercise manager
  redirect('exercises.php');
?>
