<?php
  // We'll need some functions
  require_once 'helper-func.php';

  function getProgramsByMemberId($db, $member_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

    // Prepare statement
    $columns = implode(', ', $columns);
    $qry = 'SELECT ' . $columns . ' FROM program WHERE member_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function getProgram($db, $program_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

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
?>
