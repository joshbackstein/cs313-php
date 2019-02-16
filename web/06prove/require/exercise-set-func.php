<?php
  // We'll need database access
  require_once 'db.php';

  // We'll need some functions
  require_once 'helper-func.php';

  function getExerciseSetsByExerciseId($exercise_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM exercise_set WHERE exercise_id = :id ORDER BY display_order';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getExerciseSetByExerciseSetId($exercise_set_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM exercise_set WHERE exercise_set_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_set_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  function deleteExerciseSetsByMemberId($member_id) {
    // Get database access
    $db = getDb();

    // Delete exercise sets
    $qry = 'DELETE FROM exercise_set WHERE exercise_id IN (SELECT exercise_id FROM exercise WHERE member_id = :id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteExerciseSetsByExerciseId($exercise_id) {
    // Get database access
    $db = getDb();

    // Delete exercise sets
    $qry = 'DELETE FROM exercise_set WHERE exercise_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteExerciseSetByExerciseSetId($exercise_set_id) {
    // Get database access
    $db = getDb();

    // Delete exercise set
    $qry = 'DELETE FROM exercise_set WHERE exercise_set_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_set_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function createExerciseSet($exercise_id, $weight, $repetitions, $display_order) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'INSERT INTO exercise_set (weight, repetitions, display_order, exercise_id) VALUES (:weight, :repetitions, :display_order, :exercise_id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':weight', $weight, PDO::PARAM_INT);
    $stmt->bindValue(':repetitions', $repetitions, PDO::PARAM_INT);
    $stmt->bindValue(':display_order', $display_order, PDO::PARAM_INT);
    $stmt->bindValue(':exercise_id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function updateExerciseSet($exercise_set_id, $weight, $repetitions, $display_order) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'UPDATE exercise_set SET weight = :weight, repetitions = :repetitions, display_order = :display_order WHERE exercise_set_id = :exercise_set_id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':weight', $weight, PDO::PARAM_INT);
    $stmt->bindValue(':repetitions', $repetitions, PDO::PARAM_INT);
    $stmt->bindValue(':display_order', $display_order, PDO::PARAM_INT);
    $stmt->bindValue(':exercise_set_id', $exercise_set_id, PDO::PARAM_INT);
    $stmt->execute();
  }
?>
