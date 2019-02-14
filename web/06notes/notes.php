<?php
  require_once 'db.php';
  $db = get_db();

  // Get course ID
  $course_id = htmlspecialchars($_GET['course_id']);

  // Get the course from the DB
  $query = 'SELECT course_id, name, course_code FROM course WHERE course_id = :course_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
  $statement->execute();
  $course = $statement->fetch(PDO::FETCH_ASSOC);

  // Get more data about the course
  $course_name = $course['name'];
  $course_code = $course['course_code'];

  // Get notes for course
  $query = 'SELECT note_id, date, content FROM note WHERE course_id = :course_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
  $statement->execute();
  $notes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
  <head>
    <?php
      echo '<title>Notes for ' . $course_code . ' - ' . $course_name . '</title>';
    ?>
  </head>
  <body>
    <?php
      echo '<h1>Notes for ' . $course_code . ' - ' . $course_name . '</h1>';
    ?>

    <form action="insert_note.php" method="post">
      <input type="date" name="date"><br>
      <?php
        echo '<input type="hidden" name="course_id" value="' . $course_id . '"><br>';
      ?>
      <textarea name="content"></textarea><br>
      <input type="submit" value="Insert Note">
    </form>

    <?php
      foreach ($notes as $note) {
        $note_date = $note['date'];
        $note_content = $note['content'];
        echo '<p>Date: ' . $note_date . '</p>';
        echo '<p>' . $note_content . '</p>';
      }
    ?>
  </body>
</html>
