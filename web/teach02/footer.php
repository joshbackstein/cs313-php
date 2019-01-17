<div>
  <ul>
    <?php
      if ($is_administrator || $is_tester) {
        echo '<li><a href="auth.php?logout">Logout</a></li>';
      }
    ?>
  </ul>
</div>
