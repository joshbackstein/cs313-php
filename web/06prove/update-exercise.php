<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure all of the data was passed
  $missing_data = false;
  if (!isset($_POST['exercise_id']) || strlen($_POST['exercise_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['exercise_name']) || strlen($_POST['exercise_name']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['exercise_description']) || strlen($_POST['exercise_description']) < 1) {
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
  $name = $_POST['exercise_name'];
  $description = $_POST['exercise_description'];

  // Make sure this exercise actually belongs to the member
  if (!ownsExercise($exercise_id)) {
    require_once 'require/403.php';
  }

  // Update the exercise
  updateExercise($exercise_id, $name, $description);

  // Go back to the exercise editor
  redirect('edit-exercise.php?exercise_id=' . $exercise_id);
?>
