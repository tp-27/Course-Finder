<?php
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
    <title>Riley DeConkey</title>
</head>
<body>
    <a class="link" href=<?php echo str_replace("Team104/riley/", "", $url) ?>><h1 class = "sectionText">104</h1></a>
<div class = "team-member">
    <img src="riley1.png" alt="Avatar">
    <h2>Hi! I am Riley, nice to meet you!<h2>
    <p>I'm a 4th year software engineering student at the University of Guelph, and I'm one of the 7 developers who brought you this VBA course selection assistant. I'm excited to see where this project
        goes next, and I can't wait to learn more about php!<p>
    <br>
    <p>For fun, I made this button that generates you a message about php, in one of three colours!<p>
    <br>
    <p>Click the button below to generate a random message!<p>
    <form method="post">
        <input type="submit" name="Generate" value="Generate Message"class="genbutton">
    </form>
    <?php
    if (isset($_POST['Generate'])) {
        $messages = array(
            "PHP is the best!",
            "I love PHP!",
            "I didn't want this to be just html code!",
        );
        $colours = array(
            "Black",
            "Red",
            "White"
        );
        echo "<br><font color=".$colours[array_rand($colours)].">".$messages[array_rand($messages)]."</font>";
    }
    ?>
</div>
</body>
</html>

