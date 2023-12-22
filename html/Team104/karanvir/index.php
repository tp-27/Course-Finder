<?php  
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $name = "Karanvir Basson";
    $aboutMe = "About Me";
    $aboutPoints = [
        "Fourth Year Student at the University of Guelph",
        "Enrolled in the Co-op Computer Science program",
        "Love to implement algorithms and learn new techologies in my free time!"
    ]
?>
<html>
    <head>
        <title><?php echo $name?></title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a class = "link" href = <?php echo str_replace("Team104/karanvir/", "", $url) ?>><h1 class = "sectionText">104</h1></a>
        <div class="name">
            <?php echo $name?>
        </div>
        <div class="karanvirPic">
            <img src="./karanvir.jpeg" alt="karanvir">
        </div>
        <div class="section">
            <table class="table">
                <thead>
                    <div class="sectionHeader">
                        <?php echo $aboutMe?>
                    </div>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($aboutPoints); $i++) { ?>
                        <tr>
                            <li class="aboutPoint">
                                <?php echo $aboutPoints[$i] ?>
                                </br>
                            </li>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="section">
            <div class="sectionHeader">
                PHP "FizzBuzz" Game
            </div>
            <form action="" method="get">
                <ul class="sectionDescription">
                    <li><?php echo "Number divisible by 3 --> <b>FIZZ</b>" ?></li>
                    <li><?php echo "Number divisible by 5 --> <b>BUZZ</b>" ?></li>
                    <li><?php echo "Number divisible by both 3 and 5 --> <b>FIZZBUZZ</b>" ?></li>
                    <li><?php echo "Number NOT divisible by both 3 and 5 --> <b>NEITHER</b>" ?></li>
                    <li><?php echo "Input empty or not a integer --> <b>ERROR</b>" ?></li>
                </ul>
                <div class="input">
                    <label for="num">Enter An Integer:</label>
                    <input type="text" id="num" name="num" style="margin-left: 50px; font-size:25px;" value = <?php echo $_GET['num'] ?> >
                    <input type="submit" value="Submit" class="submitButton">
                </div>
            </form>
            <?php 
                function fizzbuzz($num) {
                    $isEmpty = empty($num);
                    $isNum = is_numeric($num);
                    
                    if ($isEmpty) return "ERROR -- Empty string!";
                    if (!$isNum) return "ERROR -- Not a number!";
                    if ($num != intval($num)) return "ERROR -- Not an integer!";

                    $num = intval($num);
                    $result = '';
    
                    $divisibleBy3 = ($num % 3 == 0);
                    $divisibleBy5 = ($num % 5 == 0);
    
                    $result .= $divisibleBy3 ? "FIZZ" : '';
                    $result .= $divisibleBy5 ? "BUZZ" : '';
                    if (!$divisibleBy3 && !$divisibleBy5) $result .= "NEITHER";
    
                    return "RESULT = &nbsp; <b>$result</b>";
                }

                $num = $_GET['num'];
                $res = fizzbuzz($num);
            ?>
            <div class="result">
                <?php echo isset($_GET["num"]) ? $res : "" ?>
            </div>
        </div>
    </body>
</html>