<?php
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>

<html>
    <head>
        <title>Thomas Phan</title>
            <link rel="stylesheet" type="text/css" href="styles.css">
            <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    </head>
    <body>
        <a class="groupNum" href=<?php echo str_replace("Team104/thomas/", "", $url) ?>> 104 </a>
        <div class="content-sec">
            <img src="thomas.jpg" alt="Headshot" height="200" width="200">
            <h1>Thomas Phan<h1>
            <p>Beyond the classroom, I find solace and beauty in nature during the summers through canoe trips to Algonquin Park or Kawartha Lakes. When winter arrives, you'll spot me on the mountains (more like hills in Ontario) mindlessly snowboarding down freshly groomed slopes.</p>
            <h2>What else do you want to know about me?</h2>
            <div>
                <form action='#' method="post">
                <select name="question" id="question">
                    <option value="None"> Select a question </option>
                    <option value="1"> How many brothers do you have? </option>
                    <option value="Vietnamese"> What's your ethnicity? </option>
                    <option value="Alt-J"> Who's your is one of your favourite artist? </option>
                    <option value="Snowboard and Backcountry Camp"> If you could drop out, what would you do? </option>
                    <option value="Anything Viet"> What's your favourite food? </option>
                </select>
                <input type="submit" name="submit" value="Answer"/>

        </div>

    </body>
</html>

<?php
    if (isset($_POST['submit'])) {
        $selected_val = $_POST['question'];
        echo $selected_val;
    }
?>
