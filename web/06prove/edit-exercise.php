<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // We'll need a title
  $title = 'Edit Exercise';

  // Make sure the exercise was provided
  if (!isset($_GET['exercise_id']) || strlen($_GET['exercise_id']) < 1) {
    redirect('exercises.php');
  }

  // Make sure the exercise actually belongs to the current member
  $exercise_id = htmlspecialchars($_GET['exercise_id']);
  if (!ownsExercise($exercise_id)) {
    require_once 'require/403.php';
  }

  // Get exercise data
  $columns = [
    'member_id',
    'name',
    'description',
  ];
  $exercise = getExercise($exercise_id, $columns);
  $exercise_member_id = $exercise['member_id'];
  $exercise_name = htmlspecialchars($exercise['name']);
  $exercise_description = htmlspecialchars($exercise['description']);

  // Get exercise sets
  $columns = [
    'exercise_set_id',
    'weight',
    'repetitions',
    'display_order',
  ];
  $sets = getExerciseSetsByExerciseId($exercise_id, $columns);
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
              <h3>Exercise Details</h3>
              <form class="text-left" action="update-exercise.php" method="post">
                <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">
                <div class="form-group">
                  <label for="exercise-name">Exercise Name</label>
                  <input type="text" class="form-control" id="exercise-name" name="exercise_name" placeholder="Enter exercise name" value="<?php echo $exercise_name; ?>" required>
                </div>
                <div class="form-group">
                  <label for="exercise-description">Description</label>
                  <input type="text" class="form-control" id="exercise-description" name="exercise_description" placeholder="Enter description" value="<?php echo $exercise_description; ?>" required>
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
            <div class="content bg-a no-padding-top no-padding-bottom">
              <?php
                $counter = 0;
                $last_row = sizeof($sets);
                if ($last_row < 1) {
                  echo '<h3>No sets</h3>';
                } else {
                  foreach ($sets as $set) {
                    // Get set info
                    $set_id = $set['exercise_set_id'];
                    $set_weight = $set['weight'];
                    $set_repetitions = $set['repetitions'];
                    $set_display_order = $set['display_order'];

                    // Figure out the row classes
                    $row_class = 'row';
                    $counter += 1;
                    if ($counter == 1) {
                      // Outer rows should have larger padding
                      $row_class = $row_class . ' padding-sm-top top-row';
                    } else {
                      // Inner rows should have smaller padding
                      $row_class = $row_class . ' padding-xs-top';
                    }
                    if ($counter == $last_row) {
                      // Outer rows should have larger padding
                      $row_class = $row_class . ' padding-sm-bottom bottom-row';
                    } else {
                      // Inner rows should have smaller padding
                      $row_class = $row_class . ' padding-xs-bottom';
                    }
                    if ($counter % 2 == 1) {
                      $row_class = $row_class . ' bg-a';
                    } else {
                      $row_class = $row_class . ' bg-b';
                    }

                    // Put together column classes
                    $column_class_arr = [
                      'col-3',
                      'd-flex',
                      'align-items-center',
                    ];
                    $info_class_arr = [
                      'text-left',
                      'text-truncate',
                    ];
                    $button_class_arr = [
                      'text-right',
                      'justify-content-end',
                    ];
                    $column_class = implode(' ', $column_class_arr);
                    $info_imploded = implode(' ', $info_class_arr);
                    $button_imploded = implode(' ', $button_class_arr);
                    $info_class = $column_class . ' ' . $info_imploded;
                    $button_class = $column_class . ' ' . $button_imploded;

                    // Start row
                    echo '<div class="' . $row_class . '">';

                    // Weight
                    echo '<div class="' . $info_class . '">';
                    echo '<span class="font-weight-bold">Weight:</span>&nbsp;';
                    echo $set_weight;
                    echo '</div>';

                    // Repetitions
                    echo '<div class="' . $info_class . '">';
                    echo '<span class="font-weight-bold">Repetitions:</span>&nbsp;';
                    echo $set_repetitions;
                    echo '</div>';

                    // Display order
                    echo '<div class="' . $info_class . '">';
                    echo '<span class="font-weight-bold">Display Order:</span>&nbsp;';
                    echo $set_display_order;
                    echo '</div>';

                    // Buttons start
                    echo '<div class="' . $button_class . '">';

                    // Edit button
                    echo '<div class="padding-sm-right">';
                    echo '<a class="btn btn-dark btn-sm"';
                    echo ' href="edit-set.php?exercise_set_id=';
                    echo $set_id;
                    echo '">Edit</a>';
                    echo '</div>';

                    // Delete button
                    echo '<div>';
                    echo '<form action="delete-set.php" method="post">';
                    echo '<input type="hidden" name="exercise_id" value="';
                    echo $exercise_id;
                    echo '">';
                    echo '<input type="hidden" name="exercise_set_id" value="';
                    echo $set_id;
                    echo '">';
                    echo '<input type="submit" class="btn btn-dark btn-sm"';
                    echo ' value="Delete">';
                    echo '</form>';
                    echo '</div>';

                    // Buttons end
                    echo '</div>';

                    // End row
                    echo '</div>';
                  }
                }
              ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h3>Create Set</h3>
              <form class="text-left" action="create-set.php" method="post">
                <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">
                <div class="form-group">
                  <label for="weight">Weight</label>
                  <input type="number" class="form-control" id="weight" name="weight" placeholder="Enter weight" required>
                </div>
                <div class="form-group">
                  <label for="repetitions">Repetitions</label>
                  <input type="number" class="form-control" id="repetitions" name="repetitions" placeholder="Enter repetitions" required>
                </div>
                <div class="form-group">
                  <label for="display-order">Display Order</label>
                  <input type="number" class="form-control" id="display-order" name="display_order" placeholder="Enter display order" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Create set">
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
