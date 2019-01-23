<?php
    require("data.php");

    $name = $_POST["name"];
    $email = $_POST["email"];
    $major_code = $_POST["major"];
    $major = $majors_map[$major_code];
    $comments = $_POST["comments"];
    $continents = $_POST["continents"];
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
        Name: <?php echo $name; ?>
        <br>
        Email: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
        <br>
        Major: <?php echo $major; ?>
        <br>
        Comments: 
        <p><?php echo $comments; ?></p>
        Continents Visited:
        <br>
        <?php
            if(empty($continents)) {
                echo "none<br>";
            }
            else {
                foreach($continents as $continent) {
                    echo $continents_map[$continent] . "<br>";
                }
            }
        ?>    
</body>
</html>
