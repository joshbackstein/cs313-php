<?php
  require_once 'require/db.php';

  // We'll need some functions
  require_once 'require/helper-func.php';

  // Load and execute SQL file
  // Source: https://stackoverflow.com/a/7178917
  $sql_path = $_SERVER['HEROKU_APP_DIR'] . '/db/07prove/db.sql';
  $sql = file_get_contents($sql_path);
  $db = getDb();
  $db->exec($sql);

  // Go back to the index
  redirect('index.php');
?>
