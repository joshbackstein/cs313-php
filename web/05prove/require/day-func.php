<?php
  // We'll need some functions
  require_once 'helper-func.php';

  function getDaysByProgramId($db, $program_id, $columns = array()) {
    // Make sure columns are valid
    $columns = maybeDefaultColumns($columns);

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
?>
