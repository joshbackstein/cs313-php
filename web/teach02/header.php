<?php
  // Get page name from file name
  $page = basename($_SERVER['PHP_SELF'], ".php");

  // Set link text and bold link for current page
  $menu_text_home = 'Home';
  $menu_text_login = 'Login';
  $menu_text_about_us = 'About Us';
  if ($page == 'home') {
    $menu_text_home = '<strong>' . $menu_text_home . '</strong>';
  } elseif ($page == 'login') {
    $menu_text_login = '<strong>' . $menu_text_login . '</strong>';
  } elseif ($page == 'about-us') {
    $menu_text_about_us = '<strong>' . $menu_text_about_us . '</strong>';
  }
?>
<div>
  <ul>
    <li><a href="home.php"><?php echo $menu_text_home ?></a></li>
    <li><a href="login.php"><?php echo $menu_text_login ?></a></li>
    <li><a href="about-us.php"><?php echo $menu_text_about_us ?></a></li>
  </ul>
</div>
