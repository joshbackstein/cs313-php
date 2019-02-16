<?php
  // Always require a title to be set
  if (!isset($title)) {
    echo 'ERROR: Missing title';
    exit();
  }
  echo '<title>Weightlifting Manager - ' . $title . '</title>';
?>
<link rel="stylesheet" href="css/style.css">
