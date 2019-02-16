<?php
  // We'll need a session
  require_once 'session.php';

  // We'll need database access
  require_once 'db.php';

  // We'll need some functions
  require_once 'exercise-func.php';
  require_once 'exercise-set-func.php';
  require_once 'program-func.php';

  function getCurrentMemberId() {
    return $_SESSION['member_id'];
  }

  function getCurrentUsername() {
    return $_SESSION['username'];
  }

  function getCurrentEmail() {
    return $_SESSION['email'];
  }

  function getCurrentDisplayName() {
    return $_SESSION['display_name'];
  }

  function getNonAdminMembers() {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'SELECT member_id, username, email, display_name FROM member WHERE NOT is_admin';
    $stmt = $db->prepare($qry);
    $stmt->execute();

    // Return results
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  function memberExists($member_id) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'SELECT EXISTS(SELECT 1 FROM member WHERE member_id = :id) AS member_exists';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return results
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['member_exists'];
  }

  function deleteMemberByMemberId($member_id) {
    // Get database access
    $db = getDb();

    // Delete dependencies
    deleteExercisesByMemberId($member_id);
    deleteProgramsByMemberId($member_id);

    // Delete member
    $qry = 'DELETE FROM member WHERE member_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function createMember($username, $password_hash, $email, $display_name) {
    // Get database access
    $db = getDb();

    // Prepare statement
    $qry = 'INSERT INTO member (username, password_hash, email, display_name, created_at) VALUES (:username, :password_hash, :email, :display_name, LOCALTIMESTAMP)';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':display_name', $display_name, PDO::PARAM_STR);
    $stmt->execute();
  }

  function ownsProgram($program_id) {
    // Check if the member IDs match
    $current_member_id = getCurrentMemberId();
    $columns = [
      'member_id',
    ];
    $program = getProgram($program_id, $columns);
    $program_member_id = $program['member_id'];
    $is_owner = false;
    if ($program_member_id == $current_member_id) {
      $is_owner = true;
    }
    return $is_owner;
  }

  function ownsDay($day_id) {
    // Get database access
    $db = getDb();

    // Get member ID of exercise associated with this exercise set
    $qry = 'SELECT p.member_id FROM program p INNER JOIN day d USING (program_id) WHERE d.day_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $day_member_id = $row['member_id'];

    // Check if the member IDs match
    $current_member_id = getCurrentMemberId();
    $is_owner = false;
    if ($day_member_id == $current_member_id) {
      $is_owner = true;
    }
    return $is_owner;
  }

  function ownsDayExercise($day_exercise_id) {
    // Get database access
    $db = getDb();

    // Get member ID of exercise associated with this exercise set
    $qry = 'SELECT p.member_id FROM program p INNER JOIN day d USING (program_id) INNER JOIN day_exercise de USING (day_id) WHERE de.day_exercise_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $day_exercise_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $day_exercise_member_id = $row['member_id'];

    // Check if the member IDs match
    $current_member_id = getCurrentMemberId();
    $is_owner = false;
    if ($day_exercise_member_id == $current_member_id) {
      $is_owner = true;
    }
    return $is_owner;
  }

  function ownsExercise($exercise_id) {
    // Check if the member IDs match
    $current_member_id = getCurrentMemberId();
    $columns = [
      'member_id',
    ];
    $exercise = getExercise($exercise_id, $columns);
    $exercise_member_id = $exercise['member_id'];
    $is_owner = false;
    if ($exercise_member_id == $current_member_id) {
      $is_owner = true;
    }
    return $is_owner;
  }

  function ownsExerciseSet($exercise_set_id) {
    // Get database access
    $db = getDb();

    // Get member ID of exercise associated with this exercise set
    $qry = 'SELECT e.member_id FROM exercise e INNER JOIN exercise_set es USING (exercise_id) WHERE es.exercise_set_id = :id';
    $stmt = $db->prepare($qry);
    $stmt->bindValue(':id', $exercise_set_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $exercise_set_member_id = $row['member_id'];

    // Check if the member IDs match
    $current_member_id = getCurrentMemberId();
    $is_owner = false;
    if ($exercise_set_member_id == $current_member_id) {
      $is_owner = true;
    }
    return $is_owner;
  }
?>
