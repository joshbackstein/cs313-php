<?php
  require_once 'require/force-auth.php';

  // We'll need some functions
  require_once 'require/admin-func.php';
  require_once 'require/helper-func.php';
  require_once 'require/member-func.php';

  // Make sure the user is an admin
  $current_member_id = getCurrentMemberId();
  if (!isAdmin($current_member_id)) {
    require_once 'require/403.php';
  }

  // We'll need a title
  $title = 'Edit User';

  // Make sure the member was provided
  if (!isset($_GET['member_id']) || strlen($_GET['member_id']) < 1) {
    redirect('admin.php');
  }

  // Get member
  $member_id = $_GET['member_id'];
  $columns = [
    'username',
    'email',
    'display_name',
  ];
  $member = getMember($member_id, $columns);

  // Make sure the member actually exists
  if ($member == null) {
    $resource_not_found = 'User';
    require_once 'require/404.php';
  }

  // Get member data
  $username = htmlspecialchars($member['username']);
  $email = htmlspecialchars($member['email']);
  $display_name = htmlspecialchars($member['display_name']);

  // Administrator users cannot be edited through this interface
  if (isAdmin($member_id)) {
    require_once 'require/403.php';
  }
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
        <div class="row">
          <div class="col-12 text-center content-container">
            <div class="content bg-a">
              <form class="text-left" action="update-user.php" method="post">
                <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo $username; ?>" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password (leave blank to leave password unchanged)">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                  <label for="display-name">Display Name</label>
                  <input type="text" class="form-control" id="display-name" name="display_name" placeholder="Enter display name" value="<?php echo $display_name; ?>" required>
                </div>
                <div class="text-right">
                  <input type="submit" class="btn btn-dark" value="Update user">
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
