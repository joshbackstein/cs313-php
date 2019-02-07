<?php
    require('db.php');

    // If the ID is null, we'll set it to a non-existent ID
    $id = $_GET['id'] ?: -1;

    // Create escaped search query for displaying things on the page
    $html_escaped_id = htmlspecialchars($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        // Create and execute prepared statement
        $stmt = $db->prepare('SELECT book, chapter, verse, content FROM scriptures WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Get results as an array of associative arrays
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Don't try to display details for a scripture
        // that isn't in the database
        if (sizeof($rows) < 1) {
            echo '<h1>No scripture with ID: ' . $html_escaped_id . '</h1>';
        } else {
            // ID is unique, so we will only get one result,
            // so we can just grab the first element
            $row = $rows[0];

            // Display scripture details
            $book = $row['book'];
            $chapter = $row['chapter'];
            $verse = $row['verse'];
            $content = $row['content'];
            echo '<h1>Scripture Details</h1>';
            echo '<p><strong>' . $book . ' ' . $chapter . ':' . $verse . '</strong> - ' . $content . '</p>';
        }
        echo '<p><a href="search.php">Back to search</a></p>';
    ?>
</body>
</html>
