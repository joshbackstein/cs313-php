<?php
  function redirect($page, $code = 303) {
    header('Location: ' . $page, true, $code);
    exit();
  }

  function maybeDefaultColumns($columns) {
    if (is_array($columns) && sizeof($columns) > 0) {
      return $columns;
    }
    if (is_string($columns) && strlen($columns) > 0) {
      return array($columns);
    }
    return array('*');
  }
?>
