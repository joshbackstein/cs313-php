<?php
  require_once 'require/force-auth.php';

  // We'll need database access
  require_once 'require/db.php';

  // We'll need some functions
  require_once 'require/exercise-func.php';
  require_once 'require/member-func.php';
  require_once 'require/program-func.php';

  // We'll need a title
  $title = 'Dashboard';

  // Get the member ID for later
  $member_id = getCurrentMemberId();
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
          <div class="col-6 text-center content-container">
            <div class="content bg-a">
              <h2>Programs</h2>
              <?php
                $columns = [
                  'program_id',
                  'name',
                ];
                $programs = getProgramsByMemberId($member_id, $columns);
                if (sizeof($programs) < 1) {
                  echo '<p>No programs</p>';
                } else {
                  foreach ($programs as $program) {
                    $p_id = $program['program_id'];
                    $p_name = htmlspecialchars($program['name']);
                    echo '<p>';
                    echo '<a href="program.php?id=' . $p_id . '">';
                    echo $p_name;
                    echo '</a>';
                    echo '</p>';
                  }
                }
              ?>
            </div>
          </div>
          <div class="col-6 text-center content-container">
            <div class="content bg-a">
              <h2>Exercises</h2>
              <?php
                $columns = [
                  'exercise_id',
                  'name',
                ];
                $exercises = getExercisesByMemberIdOrdered($member_id, $columns, 'name');
                if (sizeof($exercises) < 1) {
                  echo '<p>No exercises</p>';
                } else {
                  foreach ($exercises as $exercise) {
                    $e_id = $exercise['exercise_id'];
                    $e_name = htmlspecialchars($exercise['name']);
                    echo '<p>';
                    echo '<a href="exercise.php?id=' . $e_id . '">';
                    echo $e_name;
                    echo '</a>';
                    echo '</p>';
                  }
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
