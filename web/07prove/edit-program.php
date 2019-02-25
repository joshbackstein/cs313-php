<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';
  require_once 'require/program-func.php';

  // We'll need a title
  $title = 'Edit Program';

  // Make sure the program was provided
  if (!isset($_GET['program_id']) || strlen($_GET['program_id']) < 1) {
    redirect('programs.php');
  }

  // Make sure the program actually belongs to the current member
  $program_id = htmlspecialchars($_GET['program_id']);
  if (!ownsProgram($program_id)) {
    require_once 'require/403.php';
  }

  // Get program data
  $columns = [
    'member_id',
    'name',
  ];
  $program = getProgram($program_id, $columns);
  $program_member_id = $program['member_id'];
  $program_name = htmlspecialchars($program['name']);

  // Get days for program
  $columns = [
    'day_id',
    'name',
    'display_order',
  ];
  $program_days = getDaysByProgramId($program_id, $columns);

  // Get exercises for each day
  $days_exercises = array();
  $columns = [
    'exercise_id',
    'name',
    'description',
  ];
  foreach ($program_days as $day) {
    // Associate exercises with day ID
    $day_id = $day['day_id'];
    $days_exercises[$day_id] = getExercisesByDayId($day_id);
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
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h3>Program Details</h3>
              <form class="text-left" action="update-program.php" method="post">
                <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
                <div class="form-group">
                  <label for="program-name">Program Name</label>
                  <input type="text" class="form-control" id="program-name" name="program_name" placeholder="Enter program name" value="<?php echo $program_name; ?>" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Update details">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="card">
              <div class="card-header bg-a">
                <h3>Program Days</h3>
              </div>
              <div class="d-flex flex-wrap align-items-stretch justify-content-around padding-sm-top bg-b">
                <?php
                  $next_display_order = 0;
                  foreach ($program_days as $day) {
                    // Get day info
                    $day_id = $day['day_id'];
                    $day_name = htmlspecialchars($day['name']);
                    $next_display_order = $day['display_order'] + 1;

                    // Start day
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

                    // Buttons start
                    $class = [
                      'card-footer',
                      'd-flex',
                      'justify-content-center',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Day edit button
                    echo '<div class="padding-sm-right">';
                    echo '<a class="btn btn-dark btn-sm"';
                    echo ' href="edit-day.php?day_id=' . $day_id . '">';
                    echo 'Edit</a>';
                    echo '</div>';

                    // Day delete button
                    echo '<div>';
                    echo '<form action="delete-day.php" method="post">';
                    echo '<input type="hidden" name="program_id"';
                    echo ' value="' . $program_id . '">';
                    echo '<input type="hidden" name="day_id"';
                    echo ' value="' . $day_id . '">';
                    echo '<input type="submit" class="btn btn-dark btn-sm"';
                    echo ' value="Delete">';
                    echo '</form>';
                    echo '</div>';

                    // Buttons end
                    echo '</div>';

                    // End day
                    echo '</div>';
                    echo '</div>';
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h3>Create Day</h3>
              <form class="text-left" action="create-day.php" method="post">
                <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
                <div class="form-group">
                  <label for="day-name">Name</label>
                  <input type="text" class="form-control" id="day-name" name="day_name" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                  <label for="day-display-order">Display Order</label>
                  <input type="number" class="form-control" id="day-display-order" name="day_display_order" placeholder="Enter display order" value="<?php echo $next_display_order; ?>" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Create day">
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
