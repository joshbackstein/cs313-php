<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';
  require_once 'require/day-func.php';
  require_once 'require/day-exercise-func.php';

  // We'll need a title
  $title = 'Edit Day';

  // Make sure the day was provided
  if (!isset($_GET['day_id']) || strlen($_GET['day_id']) < 1) {
    redirect('programs.php');
  }

  // Make sure the day actually belongs to the current member
  $day_id = htmlspecialchars($_GET['day_id']);
  if (!ownsDay($day_id)) {
    require_once 'require/403.php';
  }

  // Get day data
  $columns = [
    'name',
  ];
  $day = getDay($day_id, $columns);
  $day_name = htmlspecialchars($day['name']);

  // Get exercises for day
  $columns = [
    'day_exercise_id',
    'exercise_id',
    'name',
    'description',
    'display_order',
  ];
  $exercises = getExercisesByDayId($day_id);

  // Get exercise sets
  $exercises_sets = array();
  $columns = [
    'weight',
    'repetitions',
  ];
  foreach ($exercises as $exercise) {
    // Associate exercise sets with exercise ID
    $exercise_id = $exercise['exercise_id'];
    $exercises_sets[$exercise_id] = getExerciseSetsByExerciseId($exercise_id, $columns);
  }

  // Get exercises for member
  $member_id = getCurrentMemberId();
  $columns = [
    'exercise_id',
    'name',
    'description',
  ];
  $member_exercises = getExercisesByMemberIdOrdered($member_id, $columns, 'name');

  // Get exercise sets for member exercises
  $member_exercises_sets = array();
  $columns = [
    'weight',
    'repetitions',
  ];
  foreach ($member_exercises as $exercise) {
    // Associate exercise sets with exercise ID
    $exercise_id = $exercise['exercise_id'];
    $member_exercises_sets[$exercise_id] = getExerciseSetsByExerciseId($exercise_id, $columns);
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
              <h3>Day Details</h3>
              <form class="text-left" action="update-day.php" method="post">
                <input type="hidden" name="day_id" value="<?php echo $day_id; ?>">
                <div class="form-group">
                  <label for="day-name">Day Name</label>
                  <input type="text" class="form-control" id="day-name" name="day_name" placeholder="Enter day name" value="<?php echo $day_name; ?>" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Update name">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="card">
              <div class="card-header bg-a">
                <h3>Exercises</h3>
              </div>
              <div class="d-flex flex-wrap align-items-stretch justify-content-around padding-sm-top bg-b">
                <?php
                  $exercise_count = 0;
                  $next_display_order = 0;
                  foreach ($exercises as $exercise) {
                    // Get exercise info
                    $exercise_count += 1;
                    $day_exercise_id = $exercise['day_exercise_id'];
                    $exercise_id = $exercise['exercise_id'];
                    $exercise_name = htmlspecialchars($exercise['name']);
                    $exercise_description = htmlspecialchars($exercise['description']);
                    $next_display_order = $exercise['display_order'] + 1;

                    // Start exercise
                    echo '<div class="small-card">';
                    echo '<div class="card">';

                    // Exercise name and description start
                    $class = [
                      'card-header',
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

                    // Exercise name and description end
                    echo '</div>';

                    // Exercise sets start
                    $class = [
                      'list-group',
                      'list-group-flush',
                      'flex-row',
                      'flex-wrap',
                      'align-items-stretch',
                      'full-height',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Toggle displaying exercise sets
                    echo '<input type="checkbox"';
                    echo ' id="ex-' . $exercise_count . '"';
                    echo ' class="hideable-toggler">';
                    $class = [
                      'list-group-item',
                      'list-group-item-action',
                      'd-flex',
                      'align-items-center',
                      'justify-content-center',
                    ];
                    $class = implode(' ', $class);
                    echo '<label for="ex-' . $exercise_count . '"';
                    echo ' class="'. $class . '">';
                    echo '&nbsp;Sets</label>';

                    // Exercise sets display start
                    $class = [
                      'list-group-item',
                      'd-flex',
                      'flex-row',
                      'flex-wrap',
                      'justify-content-between',
                      'full-width',
                      'hideable',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Exercise sets labels
                    echo '<div class="half-width">';
                    echo 'Weight';
                    echo '</div>';
                    echo '<div class="half-width">';
                    echo 'Repetitions';
                    echo '</div>';

                    // Exercise sets
                    $exercise_sets = $exercises_sets[$exercise_id];
                    foreach ($exercise_sets as $exercise_set) {
                      // Get exercise set info
                      $exercise_set_weight = $exercise_set['weight'];
                      $exercise_set_repetitions = $exercise_set['repetitions'];

                      // Weight
                      echo '<div class="half-width">';
                      echo '<small>';
                      echo $exercise_set_weight . ' lbs';
                      echo '</small>';
                      echo '</div>';

                      // Repetitions
                      echo '<div class="half-width">';
                      echo '<small>';
                      echo $exercise_set_repetitions;
                      echo '</small>';
                      echo '</div>';
                    }

                    // Exercise sets display end
                    echo '</div>';

                    // Exercise sets end
                    echo '</div>';

                    // Buttons start
                    $class = [
                      'card-footer',
                      'd-flex',
                      'justify-content-center',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Exercise edit button
                    echo '<div class="padding-sm-right">';
                    echo '<a class="btn btn-dark btn-sm"';
                    echo ' href="edit-exercise.php?exercise_id=' . $exercise_id . '">';
                    echo 'Edit</a>';
                    echo '</div>';

                    // Exercise remove button
                    echo '<div>';
                    echo '<form action="remove-exercise.php" method="post">';
                    echo '<input type="hidden" name="day_id"';
                    echo ' value="' . $day_id . '">';
                    echo '<input type="hidden" name="day_exercise_id"';
                    echo ' value="' . $day_exercise_id . '">';
                    echo '<input type="submit" class="btn btn-dark btn-sm"';
                    echo ' value="Remove">';
                    echo '</form>';
                    echo '</div>';

                    // Buttons end
                    echo '</div>';

                    // End exercise
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
              <div class="card-header bg-a">
                <h3>Add Exercises</h3>
              </div>
              <div class="d-flex flex-wrap align-items-stretch justify-content-around padding-sm-top bg-b">
                <?php
                  $exercise_count = 0;
                  foreach ($member_exercises as $exercise) {
                    // Get exercise info
                    $exercise_count += 1;
                    $exercise_id = $exercise['exercise_id'];
                    $exercise_name = htmlspecialchars($exercise['name']);
                    $exercise_description = htmlspecialchars($exercise['description']);

                    // Start exercise
                    echo '<div class="small-card">';
                    echo '<div class="card">';

                    // Exercise name and description start
                    $class = [
                      'card-header',
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

                    // Exercise name and description end
                    echo '</div>';

                    // Exercise sets start
                    $class = [
                      'list-group',
                      'list-group-flush',
                      'flex-row',
                      'flex-wrap',
                      'align-items-stretch',
                      'full-height',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Toggle displaying exercise sets
                    echo '<input type="checkbox"';
                    echo ' id="add-ex-' . $exercise_count . '"';
                    echo ' class="hideable-toggler">';
                    $class = [
                      'list-group-item',
                      'list-group-item-action',
                      'd-flex',
                      'align-items-center',
                      'justify-content-center',
                    ];
                    $class = implode(' ', $class);
                    echo '<label for="add-ex-' . $exercise_count . '"';
                    echo ' class="'. $class . '">';
                    echo '&nbsp;Sets</label>';

                    // Exercise sets display start
                    $class = [
                      'list-group-item',
                      'd-flex',
                      'flex-row',
                      'flex-wrap',
                      'justify-content-between',
                      'full-width',
                      'hideable',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Exercise sets labels
                    echo '<div class="half-width">';
                    echo 'Weight';
                    echo '</div>';
                    echo '<div class="half-width">';
                    echo 'Repetitions';
                    echo '</div>';

                    // Exercise sets
                    $exercise_sets = $member_exercises_sets[$exercise_id];
                    foreach ($exercise_sets as $exercise_set) {
                      // Get exercise set info
                      $exercise_set_weight = $exercise_set['weight'];
                      $exercise_set_repetitions = $exercise_set['repetitions'];

                      // Weight
                      echo '<div class="half-width">';
                      echo '<small>';
                      echo $exercise_set_weight . ' lbs';
                      echo '</small>';
                      echo '</div>';

                      // Repetitions
                      echo '<div class="half-width">';
                      echo '<small>';
                      echo $exercise_set_repetitions;
                      echo '</small>';
                      echo '</div>';
                    }

                    // Exercise sets display end
                    echo '</div>';

                    // Exercise sets end
                    echo '</div>';

                    // Buttons start
                    $class = [
                      'card-footer',
                      'd-flex',
                      'justify-content-center',
                    ];
                    $class = implode(' ', $class);
                    echo '<div class="' . $class . '">';

                    // Exercise add button
                    echo '<div>';
                    echo '<form action="add-exercise.php" method="post">';
                    echo '<input type="hidden" name="day_id"';
                    echo ' value="' . $day_id . '">';
                    echo '<input type="hidden" name="exercise_id"';
                    echo ' value="' . $exercise_id . '">';
                    echo '<input type="hidden" name="day_exercise_display_order"';
                    echo ' value="' . $next_display_order . '">';
                    echo '<input type="submit" class="btn btn-dark btn-sm"';
                    echo ' value="Add">';
                    echo '</form>';
                    echo '</div>';

                    // Buttons end
                    echo '</div>';

                    // End exercise
                    echo '</div>';
                    echo '</div>';
                  }
                ?>
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
