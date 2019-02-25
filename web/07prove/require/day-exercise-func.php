<?php
  // We'll need database access
  require_once 'db.php';

  function deleteDayExercisesByMemberId($member_id) {
    // Get database access
    $db = getDb();

    // Delete day exercises
    $qry = 'DELETE FROM day_exercise WHERE day_id IN (SELECT day_id FROM day INNER JOIN program USING (program_id) WHERE member_id = :id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteDayExercisesByProgramId($program_id) {
    // Get database access
    $db = getDb();

    // Delete day exercises
    $qry = 'DELETE FROM day_exercise WHERE day_id IN (SELECT day_id FROM day WHERE program_id = :id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteDayExercisesByDayId($day_id) {
    // Get database access
    $db = getDb();

    // Delete day exercises
    $qry = 'DELETE FROM day_exercise WHERE day_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteDayExercisesByExerciseId($exercise_id) {
    // Get database access
    $db = getDb();

    // Delete day exercises
    $qry = 'DELETE FROM day_exercise WHERE exercise_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteDayExerciseByDayExerciseId($day_exercise_id) {
    // Get database access
    $db = getDb();

    // Delete day exercises
    $qry = 'DELETE FROM day_exercise WHERE day_exercise_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function addExerciseToDay($exercise_id, $day_id, $display_order) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'INSERT INTO day_exercise (display_order, day_id, exercise_id) VALUES (:display_order, :day_id, :exercise_id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':display_order', $display_order, PDO::PARAM_INT);
    $stmt->bindValue(':day_id', $day_id, PDO::PARAM_INT);
    $stmt->bindValue(':exercise_id', $exercise_id, PDO::PARAM_INT);
    $stmt->execute();
  }
?>
