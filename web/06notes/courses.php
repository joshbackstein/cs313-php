<?php
  require_once 'db.php';
  $db = get_db();

  // Get the course from the DB
  $query = 'SELECT course_id, name, course_code FROM course';
  $statement = $db->prepare($query);
  $statement->execute();
  $courses = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
  <head>
    <title>Courses</title>
  </head>
  <body>
    <h1>Notes App</h1>

    <h2>Courses</h2>

    <ul>
      <?php
        foreach ($courses as $course) {
          $course_id = $course['course_id'];
          $course_name = $course['name'];
          $course_code = $course['course_code'];
          echo '<li><a href="notes.php?course_id=' . $course_id . '">' . $course_code . ' - ' . $course_name . '</a></li>';
        }
      ?>
    </ul>
  </body>
</html>
