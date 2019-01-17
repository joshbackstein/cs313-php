<?php
  require('session.php');
?>
<!doctype html>
<html>
  <body>
    <header>
      <?php
        require('header.php');
      ?>
    </header>
    <main>
      <ul>
        <li><a href="auth.php?user=administrator">Login as Administrator</a></li>
        <li><a href="auth.php?user=tester">Login as Tester</a></li>
      </ul>
    </main>
    <footer>
      <?php
        require('footer.php');
      ?>
    </footer>
  </body>
</html>
