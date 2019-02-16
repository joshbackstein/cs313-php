<?php
  // We'll need some functions
  require_once 'admin-func.php';
  require_once 'member-func.php';

  // Set up classes
  $nav_item_class = 'nav-item';
  $index_class = $nav_item_class;
  $programs_class = $nav_item_class;
  $exercises_class = $nav_item_class;
  $admin_class = $nav_item_class;

  // Add active class to active page
  $page = basename($_SERVER['PHP_SELF'], ".php");
  if ($page == 'index') {
    $index_class = $index_class . ' active';
  } elseif ($page == 'programs') {
    $programs_class = $programs_class . ' active';
  } elseif ($page == 'exercises') {
    $exercises_class = $exercises_class . ' active';
  } elseif ($page == 'admin') {
    $admin_class = $admin_class . ' active';
  }

  // Get the member ID for later
  $member_id = getCurrentMemberId();
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-2">
  <a class="navbar-brand" href="index.php">Weightlifting Manager</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="<?php echo $index_class; ?>">
        <a class="nav-link" href="index.php">Dashboard</a>
      </li>
      <li class="<?php echo $programs_class; ?>">
        <a class="nav-link" href="programs.php">Programs</a>
      </li>
      <li class="<?php echo $exercises_class; ?>">
        <a class="nav-link" href="exercises.php">Exercises</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php
        if (isAdmin($member_id)) {
          echo '<li class="' . $admin_class . '">';
          echo '<a class="nav-link" href="admin.php">Admin Portal</a>';
          echo '</li>';
        }
      ?>
      <li class="<?php echo $nav_item_class; ?>">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>
