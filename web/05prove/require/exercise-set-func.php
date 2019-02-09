<?php
  // We'll need some functions
  require_once 'helper-func.php';

  function getExerciseSetsByExerciseId($db, $exercise_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

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
?>
