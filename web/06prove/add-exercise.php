<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/day-exercise-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['day_id']) || strlen($_POST['day_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['exercise_id']) || strlen($_POST['exercise_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['day_exercise_display_order']) || strlen($_POST['day_exercise_display_order']) < 1) {
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
  $day_id = $_POST['day_id'];
  $exercise_id = $_POST['exercise_id'];
  $day_exercise_display_order = $_POST['day_exercise_display_order'];

  // Make sure this day actually belongs to the member
  if (!ownsDay($day_id)) {
    require_once 'require/403.php';
  }

  // Make sure this exercise actually belongs to the member
  if (!ownsExercise($exercise_id)) {
    require_once 'require/403.php';
  }

  // Add the exercise to the day
  addExerciseToDay($exercise_id, $day_id, $day_exercise_display_order);

  // Go back to the day editor
  redirect('edit-day.php?day_id=' . $day_id);
?>
