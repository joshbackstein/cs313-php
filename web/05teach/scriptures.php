<?php
    require('db.php');
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
    <h1>Scripture Resources</h1>
    <?php
        $rows = $db->query('SELECT book, chapter, verse, content FROM scriptures');
        foreach ($rows as $row) {
            $book = $row["book"];
            $chapter = $row["chapter"];
            $verse = $row["verse"];
            $content = $row["content"];
            echo '<p><strong>' . $book . ' ' . $chapter . ":" . $verse . '</strong> - "' . $content . '"</p>';
        }
        echo '<p><a href="search.php">Go to search</a></p>';
    ?>
</body>
</html>
