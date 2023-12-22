<html>
    <head>
        <title>Hasen Romani</title>
        <link rel="stylesheet" href="styles.css">
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    </head>
<body>
<?php  
    $name = "Hi, I am Hasen, nice to meet you!👋";
    $aboutMe = "<p style=\"line-height: 2.0;\">I'm a passionate and dedicated individual with a deep love for technology and art that knows no bounds. As an avid problem solver, I thrive on challenges and enjoy exploring new ideas. With a background in Software Engineering, I'm constantly seeking opportunities to learn and grow. I'm always up for an adventure. My goal is to make a positive impact, both in my personal journey and in the lives of those around me. Join me as I navigate through the exciting twists and turns of life, always eager to discover what's next.</p>";
    $directors = "Some of my Favourite Directors 🎬";
    $movies = "My Favourite Movies by Them 🍿";
    $desc = "Select a Director (or all) to See Their Best Films - Welcome back Sprint 8";
    $spacing = "<br>";
    $test = "Hope you get well soon Greg";

?>  

    <div class="header">
    <a href = "https://cis3760f23-04.socs.uoguelph.ca/"><h1 style="text-align:left;">104</h1></a>
    </div>

    <div class="profile">
        <div class="profile-pic">
            <img class="profile" src="hasen.jpg" alt="Avatar">
        </div>
        <div class="intro">
            <h2 class="name"><?php echo $name; ?></h2>
        </div>
        <p><?php echo $aboutMe; ?></p>
        <p><?php echo $test; ?></p>
        <div class="intro2">
            <h2 class="movies"><?php echo $spacing; echo $directors; ?></h2>
        </div>
    </div>

    <br>

    <div class="posters">
        
        <div class="photo" name="movie1">
            <img src="photos/martinA.jpg" alt="photo" />
            <p>Martin Scorsese</p>
        </div>

        <div class="photo">
            <img src="photos/davidB.jpg" alt="photo"/>
            <p>David Fincher</p>
        </div>

        <div class="photo">
            <img src="photos/stanleyC.jpg" alt="photo" height="300px" />
            <p>Stanley Kubrick</p>
        </div>

    </div>

    <div class="intro2">
        
        <h2 class="movies"><?php echo $spacing; echo $movies; ?></h2>
        <p><?php echo $desc; ?></p>

        <form action="#" method="post">
            <label>
                <input type="checkbox" name="martin" value="1" <?php if (!empty($_POST['martin'])): ?> checked="checked"<?php endif; ?>>Martin Scorsese</input>
            </label>

            <label>
                <input type="checkbox" name="david" value="2" <?php if (!empty($_POST['david'])): ?> checked="checked"<?php endif; ?>>David Fincher</input>
            </label>

            <label>
                <input type="checkbox" name="stanley" value="3" <?php if (!empty($_POST['stanley'])): ?> checked="checked"<?php endif; ?>>Stanley Kubrick</input>
            </label>

            <div class="buttonAlign">
                <input type="submit" name="submit" value="VIEW" id="styling"/>
            <div>
        </form>
    </div>

<?php 

    if (isset($_POST['martin'])){
        echo $spacing;
        echo $martinTitle = "<h2>Films by Martin Scorsese</h2><br>";
        echo "<div class=\"posters\"><div class=\"photoFilm\" name=\"movie1\"><a target=\"_blank\" href=\"https://letterboxd.com/film/shutter-island\"><img src=\"posters/movieA.jpeg\" alt=\"photoFilm\" height=\"300px\"/><p>Shutter Island (2010)</p></a></div>
        
        <a target=\"_blank\" href=\"https://letterboxd.com/film/goodfellas\"><div class=\"photoFilm\"><img src=\"posters/movieB.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>GoodFellas (1990)</p></a></div>
        
        <div class=\"photoFilm\"><a target=\"_blank\" href=\"https://letterboxd.com/film/raging-bull\"><img src=\"posters/movieC.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>Raging Bull (1980)</p></a></div></div><br>";

        
    }

    if (isset($_POST['stanley'])){
        echo $spacing;
        echo $martinTitle = "<h2>Films by Stanley Kubrick</h2><br>";
        echo "<div class=\"posters\"><div class=\"photoFilm\" name=\"movie1\"><a target=\"_blank\" href= \"https://letterboxd.com/film/full-metal-jacket\"><img src=\"posters/movieD.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>Full Metal Jacket (1987)</p></a></div>
        
        <div class=\"photoFilm\"><a target=\"_blank\" href=\"https://letterboxd.com/film/barry-lyndon\"><img src=\"posters/movieE.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>Barry Lyndon (1975)</p></a></div>
        
        <div class=\"photoFilm\"><a target=\"_blank\" href=\"https://letterboxd.com/film/2001-a-space-odyssey\"><img src=\"posters/movieF.jpeg\" alt=\"photoFilm\" height=\"300px\"/><p>Space Odyssey (1968)</p></div></a></div> <br>";
    }

    if (isset($_POST['david'])){
        echo $spacing;
        echo $martinTitle = "<h2>Films by David Fincher</h2><br>";
        echo "<div class=\"posters\"><div class=\"photoFilm\" name=\"movie1\"><a target=\"_blank\" href=\"https://letterboxd.com/film/gone-girl\"><img src=\"posters/movieG.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>Gone Girl (2014)</p></a></div>
        
        <a target=\"_blank\" href=\"https://letterboxd.com/film/zodiac\"><div class=\"photoFilm\"><img src=\"posters/movieH.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>Zodiac (2007)</p></a></div>
        
        <div class=\"photoFilm\"><a target=\"_blank\" href=\"https://letterboxd.com/film/se7en\"><img src=\"posters/movieI.jpg\" alt=\"photoFilm\" height=\"300px\"/><p>Seven (1995)</p></a></div></div> <br>";
    }
    ?> 
    
</body>
</html>