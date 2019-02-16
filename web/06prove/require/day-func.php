<?php
  // We'll need database access
  require_once 'db.php';

  // We'll need some functions
  require_once 'day-exercise-func.php';
  require_once 'helper-func.php';

  function getDaysByProgramId($program_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM day WHERE program_id = :id ORDER BY display_order';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getDay($day_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM day WHERE day_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the day actually exists
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) < 1) {
      return null;
    }

    // We know only one day can be found,
    // so we will return it directly
    return $rows[0];
  }

  function deleteDaysByMemberId($member_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteDayExercisesByMemberId($member_id);

    // Delete days
    $qry = 'DELETE FROM day WHERE program_id IN (SELECT program_id FROM program WHERE member_id = :id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteDaysByProgramId($program_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteDayExercisesByProgramId($program_id);

    // Delete days
    $qry = 'DELETE FROM day WHERE program_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteDayByDayId($day_id) {
    // Get database access
    $db = getDb();

    // Delete day
    $qry = 'DELETE FROM day WHERE day_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function createDay($program_id, $name, $display_order) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'INSERT INTO day (name, display_order, program_id) VALUES (:name, :display_order, :id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':display_order', $display_order, PDO::PARAM_INT);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function updateDay($day_id, $name) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'UPDATE day SET name = :name WHERE day_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', $day_id, PDO::PARAM_INT);
    $stmt->execute();
  }
?>
