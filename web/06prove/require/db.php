<?php
  // This file should be included at the top of every page that requires
  // access to the database

  function getDb() {
    $db = null;
    try {
      $db_url = getenv('DATABASE_URL');
      $db_opts = parse_url($db_url);

      $db_host = $db_opts['host'];
      $db_port = $db_opts['port'];
      $db_user = $db_opts['user'];
      $db_pass = $db_opts['pass'];
      $db_name = ltrim($db_opts['path'], '/');

      $dsn = 'pgsql:host=' . $db_host . ';port=' . $db_port . ';dbname=' . $db_name;
      $db = new PDO($dsn, $db_user, $db_pass);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
      echo 'Error: ' . $ex->getMessage();
      die();
    }
    return $db;
  }
?>
