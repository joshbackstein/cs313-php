<?php
  // We'll need database access
  require_once 'db.php';

  // We'll need some functions
  require_once 'day-exercise-func.php';
  require_once 'exercise-set-func.php';
  require_once 'helper-func.php';

  function getExercisesByMemberIdOrdered($member_id, $columns = array(), $order = 'exercise_id', $reverse = false) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    if ($reverse) {
      $order = $order . ' DESC';
    }
    $qry = 'SELECT ' . $columns . ' FROM exercise WHERE member_id = :id ORDER BY ' . $order;
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getExercisesByMemberId($member_id, $columns = array()) {
    return getExercisesByMemberIdOrdered($member_id, $columns, 'exercise_id');
  }

  function getExercisesByDayId($day_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM exercise INNER JOIN day_exercise USING (exercise_id) WHERE day_id = :id ORDER BY display_order';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getExercise($exercise_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM exercise WHERE exercise_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the exercise actually exists
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) < 1) {
      return null;
    }

    // We know only one exercise can be found,
    // so we will return it directly
    return $rows[0];
  }

  function deleteExercisesByMemberId($member_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteExerciseSetsByMemberId($member_id);
    deleteDayExercisesByMemberId($member_id);

    // Delete exercises
    $qry = 'DELETE FROM exercise WHERE member_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteExerciseByExerciseId($exercise_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteExerciseSetsByExerciseId($exercise_id);
    deleteDayExercisesByExerciseId($exercise_id);

    // Delete exercise
    $qry = 'DELETE FROM exercise WHERE exercise_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function createExercise($member_id, $name, $description) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'INSERT INTO exercise (name, description, member_id) VALUES (:name, :description, :member_id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function updateExercise($exercise_id, $name, $description) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'UPDATE exercise SET name = :name, description = :description WHERE exercise_id = :exercise_id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':exercise_id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }
?>
