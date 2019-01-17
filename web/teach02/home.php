<?php
  require('session.php');

  // Redirect logged out users to login page
  if (!$is_administrator && !$is_tester) {
    header('Location: login.php', true, 303);
    exit();
  }
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
      <h1>
        <?php
          if ($is_administrator) {
            echo 'Welcome, Administrator!';
          } elseif ($is_tester) {
            echo 'Welcome, Tester!';
          } else {
            // With the redirect above, this part won't ever be displayed,
            // but it's here for reference
            echo 'Welcome! You are not logged in.';
          }
        ?>
      </h1>
    </main>
    <footer>
      <?php
        require('footer.php');
      ?>
    </footer>
  </body>
</html>
