<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/exercise-set-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // We'll need a title
  $title = 'Edit Set';

  // Make sure the exercise set was provided
  if (!isset($_GET['exercise_set_id']) || strlen($_GET['exercise_set_id']) < 1) {
    redirect('exercises.php');
  }

  // Make sure the exercise set actually belongs to the current member
  $set_id = htmlspecialchars($_GET['exercise_set_id']);
  if (!ownsExerciseSet($set_id)) {
    require_once 'require/403.php';
  }

  // Get exercise data
  $columns = [
    'weight',
    'repetitions',
    'display_order',
    'exercise_id',
  ];
  $set = getExerciseSetByExerciseSetId($set_id, $columns);
  $set_weight = $set['weight'];
  $set_repetitions = $set['repetitions'];
  $set_display_order = $set['display_order'];
  $exercise_id = $set['exercise_id'];
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
              <form class="text-left" action="update-set.php" method="post">
                <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">
                <input type="hidden" name="exercise_set_id" value="<?php echo $set_id; ?>">
                <div class="form-group">
                  <label for="weight">Weight</label>
                  <input type="number" class="form-control" id="weight" name="weight" placeholder="Enter weight" value="<?php echo $set_weight; ?>" required>
                </div>
                <div class="form-group">
                  <label for="repetitions">Repetitions</label>
                  <input type="number" class="form-control" id="repetitions" name="repetitions" placeholder="Enter repetitions" value="<?php echo $set_repetitions; ?>" required>
                </div>
                <div class="form-group">
                  <label for="display-order">Display Order</label>
                  <input type="number" class="form-control" id="display-order" name="display_order" placeholder="Enter display order" value="<?php echo $set_display_order; ?>" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Update set">
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
