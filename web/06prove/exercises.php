<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-func.php';
  require_once 'require/member-func.php';

  // We'll need a title
  $title = 'Exercises';

  // Get the member ID so we can find the exercises
  $member_id = getCurrentMemberId();

  // Get exercises
  $columns = [
    'exercise_id',
    'name',
    'description',
  ];
  $exercises = getExercisesByMemberIdOrdered($member_id, $columns, 'name');
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
          $counter = 0;
          $last_row = sizeof($exercises);
          if ($last_row > 0) {
            // Exercise list start
            echo '<div class="row">';
            echo '<div class="col-12 text-center content-container">';
            echo '<div class="content bg-a no-padding-top no-padding-bottom">';

            foreach ($exercises as $exercise) {
              // Get exercise info
              $exercise_id = htmlspecialchars($exercise['exercise_id']);
              $exercise_name = htmlspecialchars($exercise['name']);
              $exercise_description = htmlspecialchars($exercise['description']);

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

              // Exercise name
              echo '<div class="col-3 ' . $info_class . '">';
              echo '<span class="font-weight-bold">Exercise:</span>&nbsp;';
              echo $exercise_name;
              echo '</div>';

              // Exercise description
              echo '<div class="col-6 ' . $info_class . '">';
              echo '<span class="font-weight-bold">Description:</span>&nbsp;';
              echo $exercise_description;
              echo '</div>';

              // Buttons start
              echo '<div class="col-3 ' . $button_class . '">';

              // Edit button
              echo '<div class="padding-sm-right">';
              echo '<a class="btn btn-dark btn-sm"';
              echo ' href="edit-exercise.php?exercise_id=' . $exercise_id . '">';
              echo 'Edit</a>';
              echo '</div>';

              // Delete button
              echo '<div>';
              echo '<form action="delete-exercise.php" method="post">';
              echo '<input type="hidden" name="exercise_id"';
              echo ' value="' . $exercise_id . '">';
              echo '<input type="submit" class="btn btn-dark btn-sm"';
              echo ' value="Delete">';
              echo '</form>';
              echo '</div>';

              // Buttons end
              echo '</div>';

              // End row
              echo '</div>';
            }

            // Exercise list end
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        ?>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h3>Create Exercise</h3>
              <form class="text-left" action="create-exercise.php" method="post">
                <div class="form-group">
                  <label for="exercise-name">Exercise Name</label>
                  <input type="text" class="form-control" id="exercise-name" name="exercise_name" placeholder="Enter exercise name" required>
                </div>
                <div class="form-group">
                  <label for="exercise-description">Description</label>
                  <input type="text" class="form-control" id="exercise-description" name="exercise_description" placeholder="Enter description" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Create exercise">
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
