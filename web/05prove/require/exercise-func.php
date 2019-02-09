<?php
  // We'll need some functions
  require_once 'helper-func.php';

  function getExercisesByMemberId($db, $member_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM exercise WHERE member_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getExercisesByDayId($db, $day_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

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

  function getExercise($db, $exercise_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

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
?>
