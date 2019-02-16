<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-set-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['exercise_id']) || strlen($_POST['exercise_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['weight']) || strlen($_POST['weight']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['repetitions']) || strlen($_POST['repetitions']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['display_order']) || strlen($_POST['display_order']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    // Redirect to the exercise if one was provided
    if (isset($_POST['exercise_id']) && strlen($_POST['exercise_id']) > 0) {
      redirect('edit-exercise.php?exercise_id=' . $_POST['exercise_id']);
    }
    redirect('exercises.php');
  }

  // Get the data
  $exercise_id = $_POST['exercise_id'];
  $weight = $_POST['weight'];
  $repetitions = $_POST['repetitions'];
  $display_order = $_POST['display_order'];

  // Make sure this exercise actually belongs to the member
  if (!ownsExercise($exercise_id)) {
    require_once 'require/403.php';
  }

  // Create the exercise set
  createExerciseSet($exercise_id, $weight, $repetitions, $display_order);

  // Go back to the exercise editor
  redirect('edit-exercise.php?exercise_id=' . $_POST['exercise_id']);
?>
