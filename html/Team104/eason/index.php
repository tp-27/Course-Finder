<?php
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
session_start();

$words = ["To be or not to be?",
"Love what you do.",
"Life goes on.",
"Best and worst of times.",
"Happy families are alike.",
"Call me Ishmael.",
"The quick brown fox jumps.",
"Lorem ipsum sit amet.",
"Boxing wizards jump.",
"Elephant",
"Mysterious",
"Unbelievable",
"Fantastic",
"Exaggerate",
"Imagine peace.",
"Don't stop believin'.",
"Ride my bike."];

if (!isset($_SESSION['current_word'])) {
    $_SESSION['current_word'] = '';
    $_SESSION['start_time'] = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $typedWord = isset($_POST['typed_word']) ? trim($_POST['typed_word']) : '';
    if ($_SESSION['current_word'] === $typedWord) {
        $endTime = microtime(true);
        $elapsedTime = round($endTime - $_SESSION['start_time'],2);
        $score = round(1 / $elapsedTime, 2);
        $message = "Congratulations! You typed '$typedWord' in $elapsedTime seconds. Your score is $score words per second.";
    } else {
        $message = "Oops! That's incorrect. Try again.";
    }

    $_SESSION['current_word'] = $words[array_rand($words)];
}

if ($_SESSION['current_word'] === '') {
    $_SESSION['current_word'] = $words[array_rand($words)];
}

$_SESSION['start_time'] = microtime(true);
?>

<!DOCTYPE html>
<html>
<head>
<a class = "link" href = <?php echo str_replace("Team104/eason/", "", $url) ?>><h1 class = "sectionText">104</h1></a>
<title>Eason Liang</title>
</head>
<body>
<link rel="stylesheet" type="text/css" href="styles.css">
    
    <div class="team-member">
        <img src="person1.jpeg" alt="Picture of Eason Liang">
        <h2>Hi, I am Eason, nice to meet you!</h2>
        <p>I am fourth year Computer Science Student at the University of Guelph. I'm one of the developers for this project.
           For fun I've Created a small project for you guys to do it involves a typing. A random word will display in front of you're required to 
           type the word as fast as you can lets see how fast you can type! 
        </p>
    </div>
    <div class = "center-content-stuff">
        <h2>Typing Game</h2>
        <p>Type the word below as quickly as you can:</p>
        <p class = "size"><?php echo $_SESSION['current_word']; ?></p>
        <br></br>
        <form method="post">
            <label for="typed_word">Type the word:</label>
            <input type="text" id="typed_word" name="typed_word" required>
            <button type="submit">Submit</button>
        </form>
        <?php if (isset($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
