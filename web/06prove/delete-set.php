<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-set-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure the exercise set was provided
  $missing_data = false;
  if (!isset($_POST['exercise_id']) || strlen($_POST['exercise_id']) < 1) {
    $missing_data = true;
  }
  if (!isset($_POST['exercise_set_id']) || strlen($_POST['exercise_set_id']) < 1) {
    $missing_data = true;
  }
  if ($missing_data) {
    if (isset($_POST['exercise_id']) && strlen($_POST['exercise_id']) > 0) {
      redirect('edit-exercise.php?exercise_id=' . $_POST['exercise_id']);
    }
    redirect('exercises.php');
  }

  // Make sure the exercise set actually belongs to the member
  $exercise_set_id = $_POST['exercise_set_id'];
  if (!ownsExerciseSet($exercise_set_id)) {
    require_once 'require/403.php';
  }

  // Delete exercise set
  deleteExerciseSetByExerciseSetId($exercise_set_id);

  // Go back to the exercise editor
  $exercise_id = $_POST['exercise_id'];
  redirect('edit-exercise.php?exercise_id=' . $exercise_id);
?>
