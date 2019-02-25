<?php
  // We'll need database access
  require_once 'db.php';

  function isAdmin($member_id) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'SELECT is_admin FROM member WHERE member_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return the user's admin status
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['is_admin'] : false;
  }
?>
