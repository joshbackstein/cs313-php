<?php
  // We'll need database access
  require_once 'db.php';

  // We'll need some functions
  require_once 'day-func.php';
  require_once 'helper-func.php';

  function getProgramsByMemberIdOrdered($member_id, $columns = array(), $order = 'program_id', $reverse = false) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    if ($reverse) {
      $order = $order . ' DESC';
    }
    $qry = 'SELECT ' . $columns . ' FROM program WHERE member_id = :id ORDER BY ' . $order;
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getProgramsByMemberId($member_id, $columns = array()) {
    return getProgramsByMemberIdOrdered($member_id, $columns, 'program_id');
  }

  function getProgram($program_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Get database access
    $db = getDb();

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM program WHERE program_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the program actually exists
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) < 1) {
      return null;
    }

    // We know only one program can be found,
    // so we will return it directly
    return $rows[0];
  }

  function deleteProgramsByMemberId($member_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteDaysByMemberId($member_id);

    // Delete programs
    $qry = 'DELETE FROM program WHERE member_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function deleteProgramByProgramId($program_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteDaysByProgramId($program_id);

    // Delete program
    $qry = 'DELETE FROM program WHERE program_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function createProgram($member_id, $name) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'INSERT INTO program (name, created_at, last_modified, member_id) VALUES (:name, LOCALTIMESTAMP, LOCALTIMESTAMP, :id)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function updateProgram($program_id, $name) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'UPDATE program SET name = :name WHERE program_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', $program_id, PDO::PARAM_INT);
    $stmt->execute();
  }
?>
