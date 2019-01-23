<?php
    require("data.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body>
    <form action="results.php" method="post">
        Name: <input name="name" type="text">
        <br>
        Email: <input name="email" type="text">
        <br>
        Major: 
        <ul>
            <?php
                foreach ($majors_map as $code => $long) {
                    echo '<li><input name="major" type="radio" value="'.$code.'">'.$long.'</li>';
                }
            ?>
        </ul>
        Comments: 
        <br>
        <textarea name="comments"></textarea>
        <br>
        Continents Visited:
        <br>
        <?php
            foreach ($continents_map as $code => $long) {
                echo '<input name="continents[]" type="checkbox" value="'.$code.'"> '.$long.'<br>';
            }
        ?>

        <input type="submit">
    </form>
    
</body>
</html>
