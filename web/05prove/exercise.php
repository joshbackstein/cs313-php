<?php
  require_once 'require/force-auth.php';

  // We'll need database access
  require_once 'require/db.php';

  // We'll need some functions
  require_once 'require/exercise-func.php';
  require_once 'require/exercise-set-func.php';
  require_once 'require/helper-func.php';

  // We'll need a title
  $title = 'Exercise Details';

  // If no exercise ID was provided, return the
  // user to the main page
  if (!isset($_GET['id']) || strlen($_GET['id']) < 1) {
    redirect('index.php');
  }

  // Get information about the exercise
  $exercise_id = $_GET['id'];
  $columns = [
    'name',
    'description',
    'member_id',
  ];
  $exercise = getExercise($db, $exercise_id, $columns);

  // Was the exercise found?
  if ($exercise == null) {
    $resource_not_found = 'Exercise';
    require 'require/404.php';
  }

  $exercise_name = $exercise['name'];
  $exercise_description = $exercise['description'];
  $exercise_member_id = $exercise['member_id'];

  // Make sure the exercise actually belongs to the
  // current user
  if ($member_id != $exercise_member_id) {
    redirect('index.php');
  }

  // The current user owns the exercise, so get the
  // associated exercise sets
  $columns = [
    'weight',
    'repetitions',
  ];
  $sets = getExerciseSetsByExerciseId($db, $exercise_id, $columns);
?>
<!doctype html>
<html>
  <head>
    <?php require 'require/bootstrap-head.php'; ?>
    <?php require 'require/template-head.php'; ?>
  </head>
  <body>
    <div class="body-container">
      <?php require 'require/template-nav.php'; ?>

      <main class="container">
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content">
              <h5>Exercise:</h5>
              <h1><?php echo $exercise_name; ?></h1>
              <h4><?php echo $exercise_description; ?></h4>
            </div>
          </div>
        </div>
        <?php
          // Were any sets found for this exercise?
          if (sizeof($sets) < 1) {
            // Start error row
            echo '<div class="row">';
            echo '<div class="col-12 text-center content-container">';
            echo '<div class="content">';

            // Display error
            echo '<h1>No sets found for this exercise</h1>';

            // End error row
            echo '</div>';
            echo '</div>';
            echo '</div>';
          } else {
            $num = 0;
            foreach ($sets as $set) {
              $num += 1;

              // Start set row
              echo '<div class="row">';
              echo '<div class="col-12 text-center content-container">';
              echo '<div class="content">';

              // Start title row
              echo '<div class="row">';

              // Display title
              echo '<div class="col-12">';
              echo '<h2>Set ' . $num . '</h2>';
              echo '</div>';

              // End title row
              echo '</div>';

              // Start information row
              echo '<div class="row">';

              // Display weight
              $weight = $set['weight'];
              echo '<div class="col-6">';
              echo '<h4>Weight: ' . $weight . ' lbs</h4>';
              echo '</div>';

              // Display repetitions
              $repetitions = $set['repetitions'];
              echo '<div class="col-6">';
              echo '<h4>Repetitions: ' . $repetitions . '</h4>';
              echo '</div>';

              // End information row
              echo '</div>';

              // End set row
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          }
        ?>
      </main>

      <footer>
        <?php require 'require/template-footer.php'; ?>
      </footer>

      <?php require 'require/bootstrap-foot.php'; ?>
    </div>
  </body>
</html>
