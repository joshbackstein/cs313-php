<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/day-func.php';
  require_once 'require/exercise-func.php';
  require_once 'require/member-func.php';
  require_once 'require/program-func.php';

  // We'll need a title
  $title = 'Programs';

  // Get the member ID so we can find the programs
  $member_id = getCurrentMemberId();

  // Get programs
  $columns = [
    'program_id',
    'name',
    'created_at',
    'last_modified',
  ];
  $programs = getProgramsByMemberIdOrdered($member_id, $columns, 'last_modified', true);

  // Get days for each program
  $programs_days = array();
  $columns = [
    'day_id',
    'name',
  ];
  foreach ($programs as $program) {
    // Associate days with program ID
    $program_id = $program['program_id'];
    $programs_days[$program_id] = getDaysByProgramId($program_id, $columns);
  }

  // Get exercises for each day
  $days_exercises = array();
  $columns = [
    'name',
    'description',
  ];
  foreach ($programs_days as $program_days) {
    foreach ($program_days as $day) {
      // Associate exercises with day ID
      $day_id = $day['day_id'];
      $days_exercises[$day_id] = getExercisesByDayId($day_id, $columns);
    }
  }
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
            <div class="content bg-a">
              <h1><?php echo $title; ?></h1>
            </div>
          </div>
        </div>
        <?php
          if (sizeof($programs) > 0) {
            foreach ($programs as $program) {
              // Get program info
              $program_id = $program['program_id'];
              $program_name = htmlspecialchars($program['name']);
              $program_created_at = $program['created_at'];
              $program_last_modified = $program['last_modified'];

              // Program start
              echo '<div class="row">';
              echo '<div class="col-12 text-center content-container">';
              echo '<div class="card">';

              // Program name
              echo '<div class="card-header bg-a">';
              echo '<h5>' . $program_name . '</h5>';
              echo '</div>';

              // Days start
              $class = [
                'd-flex',
                'flex-wrap',
                'align-items-stretch',
                'justify-content-around',
                'padding-sm-top',
                'bg-b',
              ];
              $class = implode(' ', $class);
              echo '<div class="' . $class . '">';

              // Display days
              $days = $programs_days[$program_id];
              foreach ($days as $day) {
                // Get day info
                $day_id = $day['day_id'];
                $day_name = htmlspecialchars($day['name']);

                // Day start
                echo '<div class="small-card">';
                echo '<div class="card">';

                // Day name
                echo '<div class="card-header">';
                echo $day_name;
                echo '</div>';

                // Exercises start
                $class = [
                  'list-group',
                  'list-group-flush',
                  'd-flex',
                  'flex-row',
                  'flex-wrap',
                  'align-items-stretch',
                  'full-height',
                ];
                $class = implode(' ', $class);
                echo '<div class="' . $class . '">';

                // Display exercises
                $exercises = $days_exercises[$day_id];
                foreach ($exercises as $exercise) {
                  // Get exercise info
                  $exercise_name = htmlspecialchars($exercise['name']);
                  $exercise_description = htmlspecialchars($exercise['description']);

                  // Exercise start
                  $class = [
                    'list-group-item',
                    'd-flex',
                    'flex-column',
                    'justify-content-center',
                    'full-width',
                  ];
                  $class = implode(' ', $class);
                  echo '<div class="' . $class . '">';

                  // Exercise name
                  echo '<div>';
                  echo $exercise_name;
                  echo '</div>';

                  // Exercise description
                  echo '<div>';
                  echo '<small class="text-muted">';
                  echo $exercise_description;
                  echo '</small>';
                  echo '</div>';

                  // Exercise end
                  echo '</div>';
                }

                // Exercises end
                echo '</div>';

                // Day end
                echo '</div>';
                echo '</div>';
              }

              // Days end
              echo '</div>';

              // Program footer start
              echo '<div class="card-footer bg-a">';
              echo '<div class="row align-items-center">';

              // Program creation date
              echo '<div class="col-4 text-left text-muted">';
              echo '<small>';
              $created_at = date_create($program_created_at);
              echo 'Created: ' . date_format($created_at, 'j M Y g:i:s A');
              echo '</small>';
              echo '</div>';

              // Buttons start
              $class = [
              'col-4',
              'text-center',
              'text-white',
              'd-flex',
              'justify-content-center',
              ];
              $class = implode(' ', $class);
              echo '<div class="' . $class . '">';

              // Program edit button
              echo '<div class="padding-sm-right">';
              echo '<a class="btn btn-dark btn-sm"';
              echo ' href="edit-program.php?program_id=' . $program_id . '">';
              echo 'Edit</a>';
              echo '</div>';

              // Program delete button
              echo '<div>';
              echo '<form action="delete-program.php" method="post">';
              echo '<input type="hidden" name="program_id"';
              echo ' value="' . $program_id . '">';
              echo '<input type="submit" class="btn btn-dark btn-sm"';
              echo ' value="Delete">';
              echo '</form>';
              echo '</div>';

              // Buttons end
              echo '</div>';

              // Program modification date
              echo '<div class="col-4 text-right text-muted">';
              echo '<small>';
              $last_modified = date_create($program_last_modified);
              echo 'Last modified: ' . date_format($last_modified, 'j M Y g:i:s A');
              echo '</small>';
              echo '</div>';

              // Program footer end
              echo '</div>';
              echo '</div>';

              // Program end
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          }
        ?>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h3>Create Program</h3>
              <form class="text-left" action="create-program.php" method="post">
                <div class="form-group">
                  <label for="program-name">Program Name</label>
                  <input type="text" class="form-control" id="program-name" name="program_name" placeholder="Enter program name" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Create program">
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>

      <footer>
        <?php require 'require/template-footer.php'; ?>
      </footer>

      <?php require 'require/bootstrap-foot.php'; ?>
    </div>
  </body>
</html>
