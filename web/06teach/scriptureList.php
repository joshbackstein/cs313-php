<?php require ('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Scripture List</title>
</head>
<body>
	<?php
		foreach ($db->query('SELECT id, book, chapter, verse, content FROM scriptures') as $row) {
			$scripture_id = $row["id"];
			$book = $row["book"];
			$chapter = $row["chapter"];
			$verse = $row["verse"];
			$content = $row["content"];

			$stmt = $db->prepare("SELECT name FROM topics INNER JOIN scriptures_topics USING (topic_id) WHERE scriptures_id = :scriptures_id");
			$stmt->bindValue(":scriptures_id", $scripture_id, PDO::PARAM_INT);
			$stmt->execute();
		    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

			echo "<p><strong>$book $chapter:$verse</strong> - $content</p>";
			echo "<ul>";
			foreach ($topics as $topic_name) {
				echo "<li>$topic_name</li>";
			}
			echo "</ul>";
		}
	?>
</body>
</html>