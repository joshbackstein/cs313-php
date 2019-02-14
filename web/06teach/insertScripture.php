<?php
	require ('db.php'); 

	$book = htmlspecialchars($_POST['book']);
	$chapter = htmlspecialchars($_POST['chapter']);
	$verse = htmlspecialchars($_POST['verse']);
	$content = htmlspecialchars($_POST['content']);
	$topics = htmlspecialchars($_POST['topics']);

	$stmt = $db->prepare("INSERT INTO scriptures(book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)");
	$stmt->bindValue(':book', $book, PDO::PARAM_STR);
	$stmt->bindValue(':chapter', $chapter, PDO::PARAM_INT);
	$stmt->bindValue(':verse', $verse, PDO::PARAM_INT);
	$stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();

    $newId = $db->lastInsertId('scriptures_id_seq');

    foreach ($topics as $topic_id) {
    	$stmt = $db->prepare("INSERT INTO scriptures_topics(scripture_id, topic_id) VALUES (:scripture_id, :topic_id)");
		$stmt->bindValue(':scripture_id', $newId, PDO::PARAM_INT);
		$stmt->bindValue(':topic_id', $topic_id, PDO::PARAM_INT);
    	$stmt->execute();
    }

    header("Location: scriptureList.php");
?>