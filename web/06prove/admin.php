<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/admin-func.php';
  require_once 'require/member-func.php';

  // Make sure current user is an admin
  $current_member_id = getCurrentMemberId();
  if (!isAdmin($current_member_id)) {
    require_once 'require/403.php';
  }

  // We'll need a title
  $title = 'Admin Portal';

  // Get members
  $members = getNonAdminMembers();
?>
<!doctype html>
<html>
  <head>
    <?php require 'require/bootstrap-head.php'; ?>
    <?php require 'require/template-head.php'; ?>
  </head>
  <body>
    <div class="body-container">
      <?php require 'require/template-nav.php'; ?>

      <main class="container">
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h1><?php echo $title; ?></h1>
            </div>
          </div>
        </div>
        <?php
          $counter = 0;
          $last_row = sizeof($members);
          if ($last_row > 0) {
            // Member list start
            echo '<div class="row">';
            echo '<div class="col-12 text-center content-container">';
            echo '<div class="content bg-a no-padding-top no-padding-bottom">';

            foreach ($members as $member) {
              // Get member info
              $member_id = htmlspecialchars($member['member_id']);
              $username = htmlspecialchars($member['username']);
              $email = htmlspecialchars($member['email']);
              $display_name = htmlspecialchars($member['display_name']);

              // Figure out the row classes
              $row_class = 'row';
              $counter += 1;
              if ($counter == 1) {
                // Outer rows should have larger padding
                $row_class = $row_class . ' padding-sm-top top-row';
              } else {
                // Inner rows should have smaller padding
                $row_class = $row_class . ' padding-xs-top';
              }
              if ($counter == $last_row) {
                // Outer rows should have larger padding
                $row_class = $row_class . ' padding-sm-bottom bottom-row';
              } else {
                // Inner rows should have smaller padding
                $row_class = $row_class . ' padding-xs-bottom';
              }
              if ($counter % 2 == 1) {
                $row_class = $row_class . ' bg-a';
              } else {
                $row_class = $row_class . ' bg-b';
              }

              // Put together column classes
              $column_class_arr = [
                'd-flex',
                'align-items-center',
              ];
              $data_class_arr = [
                'col-3',
                'text-left',
                'text-truncate',
              ];
              $button_class_arr = [
                'col-3',
                'text-right',
                'justify-content-end',
              ];
              $column_class = implode(' ', $column_class_arr);
              $data_imploded = implode(' ', $data_class_arr);
              $button_imploded = implode(' ', $button_class_arr);
              $data_class = $data_imploded . ' ' . $column_class;
              $button_class = $button_imploded . ' ' . $column_class;

              // Start row
              echo '<div class="' . $row_class . '">';

              // Username
              echo '<div class="' . $data_class . '">';
              echo '<span class="font-weight-bold">';
              echo 'Username:';
              echo '</span>&nbsp;';
              echo $username;
              echo '</div>';

              // Email
              echo '<div class="' . $data_class . '">';
              echo '<span class="font-weight-bold">';
              echo 'Email:';
              echo '</span>&nbsp;';
              echo $email;
              echo '</div>';

              // Display name
              echo '<div class="' . $data_class . '">';
              echo '<span class="font-weight-bold">';
              echo 'Display Name:';
              echo '</span>&nbsp;';
              echo $display_name;
              echo '</div>';

              // Delete button
              echo '<div class="' . $button_class . '">';
              echo '<form action="delete-user.php" method="post">';
              echo '<input type="hidden" name="member_id"';
              echo ' value="' . $member_id . '">';
              echo '<input type="submit" class="btn btn-dark btn-sm"';
              echo ' value="Delete">';
              echo '</form>';
              echo '</div>';

              // End row
              echo '</div>';
            }

            // Member list end
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        ?>
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <h3>Create User</h3>
              <form class="text-left" action="create-user.php" method="post">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                  <label for="display-name">Display Name</label>
                  <input type="text" class="form-control" id="display-name" name="display_name" placeholder="Enter display name" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Create user">
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>

      <footer>
        <?php require 'require/template-footer.php'; ?>
      </footer>

      <?php require 'require/bootstrap-foot.php'; ?>
    </div>
  </body>
</html>
