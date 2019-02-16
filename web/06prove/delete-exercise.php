<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure the exercise was provided
  if (!isset($_POST['exercise_id']) || strlen($_POST['exercise_id']) < 1) {
    redirect('exercises.php');
  }

  // Make sure the exercise actually belongs to the current member
  $exercise_id = $_POST['exercise_id'];
  if (!ownsExercise($exercise_id)) {
    require_once 'require/403.php';
  }

  // Delete exercise
  deleteExerciseByExerciseId($exercise_id);

  // Go back to exercise manager
  redirect('exercises.php');
?>
