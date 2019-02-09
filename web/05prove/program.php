<?php
  require_once 'require/force-auth.php';

  // We'll need database access
  require_once 'require/db.php';

  // We'll need some functions
  require_once 'require/day-func.php';
  require_once 'require/exercise-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/program-func.php';

  // We'll need a title
  $title = 'Program Details';

  // If no program ID was provided, return the
  // user to the main page
  if (!isset($_GET['id']) || strlen($_GET['id']) < 1) {
    redirect('index.php');
  }

  // Get information about the program
  $program_id = $_GET['id'];
  $columns = [
    'name',
    'member_id',
  ];
  $program = getProgram($db, $program_id, $columns);

  // Was the program found?
  if ($program == null) {
    $resource_not_found = 'Program';
    require 'require/404.php';
  }

  $program_name = $program['name'];
  $program_member_id = $program['member_id'];

  // Make sure the program actually belongs to the
  // current user
  if ($member_id != $program_member_id) {
    redirect('index.php');
  }

  // The current user owns the program, so get the
  // associated days
  $columns = [
    'day_id',
    'name',
  ];
  $days = getDaysByProgramId($db, $program_id, $columns);
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
              <h5>Program:</h5>
              <h1><?php echo $program_name; ?></h1>
            </div>
          </div>
        </div>
        <?php
          // Were any days found for this program?
          if (sizeof($days) < 1) {
            // Start error row
            echo '<div class="row">';
            echo '<div class="col-12 text-center content-container">';
            echo '<div class="content">';

            // Display error
            echo '<h1>No days found for this program</h1>';

            // End error row
            echo '</div>';
            echo '</div>';
            echo '</div>';
          } else {
            $counter = 1;
            $num_days = count($days);
            foreach ($days as $day) {
              // Each row will contain two columns. Every odd column will
              // be the start of a new row. This should work as long as
              // $counter starts at 1.
              if ($counter % 2 == 1) {
                echo '<div class="row justify-content-center">';
              }

              // Start column
              echo '<div class="col-6 text-center content-container">';
              echo '<div class="content">';

              // Display day name
              $day_id = $day['day_id'];
              $day_name = $day['name'];
              echo '<h2>' . $day_name . '</h2>';

              // Display exercise names and descriptions
              $columns = [
                'name',
                'description',
              ];
              $exercises = getExercisesByDayId($db, $day_id, $columns);
              foreach ($exercises as $exercise) {
                $exercise_name = $exercise['name'];
                $exercise_description = $exercise['description'];
                echo '<h5>' . $exercise_name . '</h5>';
                echo '<p>' . $exercise_description . '</p>';
              }

              // End column
              echo '</div>';
              echo '</div>';

              // Every even column is the last column in the row, so we
              // need to close the row. In addition, if this is the last
              // column, we need to close the row. $counter should equal
              // $num_days at the end of the loop as long as $counter
              // starts at 1.
              if ($counter % 2 == 0 || $counter == $num_days) {
                echo '</div>';
              }

              // Increment the counter for the next day
              $counter += 1;
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
