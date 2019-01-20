<!DOCTYPE html>
<html>
  <head>
    <title>CS 313 - 02 Prove - Homepage</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <h1 class="title">Welcome to my homepage!</h1>

      <div class="nav">
        <div id="nav-title">
          Navigation
        </div>
        <div id="nav-items">
          <a href="/02prove/assignments.php">CS 313 Assignments</a>
        </div>
      </div>

      <hr />

      <div class="content-container-outer">
        <div class="content-container-inner">
          <div class="content">
            <img id="profile-picture" src="images/silhouette-420.jpg" alt="Silhouette of a lizard on a leaf">
            <p id="profile-picture-attribution"><a href="https://www.flickr.com/photos/36302954@N00/475571502">Photo by SaraYeomans at Flickr</a></p>
          </div>

          <div class="content">
            <p>Hi! I'm a computer science student at Brigham Young University - Idaho, and I'll be graduating in April. I have interned with companies in Boise, ID and Seattle, WA. I love learning about things in the software stack that hold everything together, such as operating systems and kernels, compilers, and dependency management.</p>
            </p>
          </div>
        </div>
      </div>

      <div class="footer">
        <?php
          date_default_timezone_set('America/Boise');
          $time = date('g:i:s A T');
          $date = date('j F Y');

          echo 'Page loaded at ' . $time . ' on ' . $date;
        ?>
      </div>
    </div>
  </body>
</html>
