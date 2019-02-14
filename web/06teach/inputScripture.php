<?php 
	require ('db.php'); 
 	$stmt = $db->prepare("SELECT topic_id, name FROM topics ORDER BY name");
    $stmt->execute();
    // Get results as an array of associative arrays
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Input Scripture</title>
</head>
<body>
	<form action="insertScripture.php" method="POST">
		<input type="text" name="book">Book<br>
		<input type="text" name="chapter">Chapter<br>
		<input type="text" name="verse">Verse<br>
		<textarea name="content"></textarea><br>
		<?php
			foreach ($topics as $row) {
				$topic_id = $row['topic_id'];
				$topic_name = $row['name'];
				echo '<input type="checkbox" name="topics[]" value="' . $topic_id . '"/>' . $topic_name . '<br>';
			}
		?>
		<button type="submit">Add Scripture</button>
	</form>
</body>
</html>