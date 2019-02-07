<?php
    require('db.php');

    // If search query is null, we'll set it to an empty string
    $search_query = $_GET['query'] ?: '';

    // Strip leading and trailing whitespace
    $search_query = trim($search_query);

    // Create escaped search query for displaying things on the page
    $html_escaped_query = htmlspecialchars($search_query);
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
        // Don't try to display results for an empty query
        if (strlen($search_query) < 1) {
            echo '<h1>Empty search query submitted</h1>';
        } else {
            // Create and execute prepared statement
            // Using 'LIKE' allows us to get partial matches
            // The '%' symbol is used as a wildcard
            // The '||' is for concatenation
            // The sanitized string ends up looking something like this:
            //    '%sanitized input goes here%'
            // Using this, something like 'oh' would return results for 'John'
            $stmt = $db->prepare("SELECT id, book, chapter, verse FROM scriptures WHERE book_lower LIKE lower('%'||:book_lower||'%')");
            $stmt->bindValue(':book_lower', $search_query, PDO::PARAM_STR);
            $stmt->execute();

            // Display search query
            echo '<h1>Results for: ' . $html_escaped_query . '</h1>';

            // Get results as an array of associative arrays
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Don't try to display rows when none exist
            if (sizeof($rows) < 1) {
                echo '<p>No results</p>';
            } else {
                // Display results
                foreach ($rows as $row) {
                    $id = $row['id'];
                    $url = 'details.php?id=' . $id;
                    $book = $row['book'];
                    $chapter = $row['chapter'];
                    $verse = $row['verse'];
                    echo '<p><a href="' . $url .'">' . $book . ' ' . $chapter . ':' . $verse . '</a></p>';
                }
            }
        }
        echo '<p><a href="search.php">Back to search</a></p>';
    ?>
</body>
</html>
