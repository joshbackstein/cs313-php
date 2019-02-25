<?php
  require_once 'session.php';

  // We'll need access to the database
  require_once 'db.php';

  // Make sure user is logged in
  if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
  }

  // Get username
  $db = getDb();
  $qry = 'SELECT username FROM member_teach_07 WHERE member_id = :id';
  $stmt = $db->prepare($qry);
  $stmt->bindValue(':id', $_SESSION['member_id'], PDO::PARAM_INT);
  $stmt->execute();
  $member = $stmt->fetch(PDO::FETCH_ASSOC);
  $username = htmlspecialchars($member['username']);
?>
<!doctype>
<html>
  <head>
    <title>07 Teach - Welcome</title>
  </head>
  <body>
    <?php
      echo '<h1>Welcome ' . $username . '</h1>';
    ?>
  </body>
</html>
