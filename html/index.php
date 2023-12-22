<?php
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Group_104</title>
        <link rel="stylesheet" href="styles.css">
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="shortcut icon" type="image/x-icon" href="media/favicon.ico"/>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous"></script>
        <script type="text/javascript">
            var staticGifSuffix = ".jpg";
            var gifSuffix = ".gif";
            $(document).ready(function() {
                $(".stepsImage").each(function () {
                $(this).hover(
                function()
                {
            var originalSrc = $(this).attr("src");
            $(this).attr("src", originalSrc.replace(staticGifSuffix, gifSuffix));
            },
            function()
            {
             var originalSrc = $(this).attr("src");
             $(this).attr("src", originalSrc.replace(gifSuffix, staticGifSuffix));  
            }
            );
        });
    });
</script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg ms-auto" style="background-color: #1D75DE;">
                <div class="container-fluid"  style="background-color: #1D75DE;">
                    <a class="navbar-brand">104</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                        <a class="nav-link" href="#features">Features ✅</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#setup">Setup 🔌</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#using">Using the Software ⌨️</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#aboutTeam">Team 🧑‍💻</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href=<?php echo $url . "pages/ApiDoc/" ?>>Api Documentation 📄</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href=<?php echo $url . "pages/ApiFrontend/" ?>>Api Frontend 🖥️</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href=<?php echo $url . "pages/ApiTree/" ?>>Api Tree 🌳</a>
                        </li>
                    </ul>
                    </div>
                </div>
            </nav>

        <section class="homepageBody">
            <p class="homepageBodyTitle">F_23_CIS3760: Group_104</p>
            <p class="homepageBodyText">
                Welcome to Group 104's PHP-powered homepage, where innovation and collaboration thrive 🚀.
            </p>
            <div class="VBAdownload">
                <div class="text_button">
                    <p class="VBAdownload_text">Introducing VBA Induced Student Course Management Tool</p>
                    <a href="./downloads/Sprint2_Final.xlsm" class="a_button">Download Excel</a>
                    <!-- <a href=<?php echo $url . "pages/ApiExamples/" ?> class="a_button">Web Api</a> -->
                </div>
                <img class="macbook" src="./media/macbook.png" alt="macbook.png">
            </div>
        </section>
       

        <section class="feature1" id="features">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1> Free To Use </h1>
                    <h2 class = "featuredescriptionText">   COURSE MANAGER ® remains a free product for educational staff and students to use  </h2>
                </div>
                <img class="feature-image" src="./media/free.png" alt="free"> 
            </div>
            
        </section>


        <section class="feature1" style="background-color: #175EB2">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1>No External Software Needed </h1>
                    <h2 class = "featuredescriptionText">    Our application runs all within Microsoft Excel, no need to install any third party applications  </h2>
                </div>
                <img class="feature-image" src="./media/Microsoft_Office_13-16_Logo.png" alt="Office Logo"> 
            </div>
        </section>

        <section class="feature1" style="background-color: #14529B">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1> Minimalistic Design </h1>
                    <h2 class = "featuredescriptionText">  No hassle in navigating through endless menus to find the correct options needed. Simply press a button to enter your courses, and then another to find the ones you can take  </h2>
                </div>
                <img class="feature-image" src="./media/minimalistic.png" alt="Minimalistic">
            </div>
        </section>

        <section class="feature1">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1> Robust End Product </h1>
                    <h2 class = "featuredescriptionText">  Our developers have extensively tested this product from preventing the software from crashing to make the user experience better  </h2>
                </div>
                <img class="feature-image" src="./media/robust.png" alt="Robust">
            </div>
        </section>


        <section class="feature1" style="background-color: #175EB2">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1> Secure </h1>
                    <h2 class = "featuredescriptionText"> COURSE MANAGER ® Only runs and stores data locally within the users device. Not communicating over any networks ensures that private user information cannot be stolen   </h2>
                </div>
                <img class="feature-image" src="./media/secure.png" alt="Secure">
            </div>
        </section>


        <section class="feature1" style="background-color: #14529B">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1> Offline Functionally  </h1>
                    <h2 class = "featuredescriptionText">  Storing all data and handling all process within the user device also means that no internet connection is required to run the program  </h2>
                </div>
                <img class="feature-image" src="./media/offlineFeature.png" alt= "Offline">
            </div>
        </section>


        <section class="feature1">
            <!-- <div class="lastFeatureDiv"> -->
                <div class="feature1-body">
                    <div class="feature1-desc">
                        <h1> Open Source </h1>
                        <h2 class = "featuredescriptionText">Users not happy with a certain aspect of the software or would like to add additional functionality can directly edit the program to make it meet their needs </h2>
                    </div>
                    <img class="feature-image" src="./media/open-source.png" alt= "Open Source">
                    
                </div>
            <!-- </div> -->
        </section>
        <section class="using" id="setup">
            <h1>Getting Started</h1>
            <div class="using-container">
                <div class="using-steps">
                    <h1>Step 1: Download The Software</h1>
                    <img class="stepsImage" src="./media/download.jpg" alt="Download">
                </div>
                <div class="using-steps">
                    <h1>Step 2: Enable Permissions</h1>
                    <img  class = "stepsImage"  src="./media/enable-permissions.jpg" alt= "Enable permissions">
                </div>
                <div class="using-steps">
                    <h1> Step 3: Open the excel workbook</h1>
                    <img class="stepsImage" src="./media/open.jpg"alt="Open">
                </div>
            </div>
        </section>
        <section class="using" id="using">
        <h1> Using The Software </h1>
            <div class="using-container">
                <div class="using-steps">
                    <h1>Step 1: Enter Your Courses</h1>
                    <img  class = "stepsImage" src="./media/add_course.jpg" alt="Add">
                </div>

                <div class="using-steps">
                    <h1>Step 2: Generate & View The eligible courses</h1>
                    <img  class = "stepsImage"  src="./media/load_courses.jpg" alt="Load">
                </div>

                <div class="using-steps">
                    <h1>Step 3: Delete Unwanted Courses</h1>
                    <img  class = "stepsImage"  src="./media/delete_courses.jpg" alt= "delete">
                </div>
            </div>
        </section>

        <section class="contributors" id="aboutTeam">
            <h1>Our Team</h1>
            <div class="contributor-content">
                    <a href=<?php echo $url . "Team104/hasen/" ?>>
                        <div class="team-member">
                            <img src="./Team104/hasen/hasen.jpg" alt="Picture of Hasen Romani" height="100px" width="100px">
                            <h2>Hasen Romani</h2>
                        </div>
                    <a href=<?php echo $url . "Team104/dawoud/" ?>>
                        <div class="team-member">
                            <img src="./Team104/dawoud/dawoud-logo.png" alt="Picture of Dawoud Husain" height="100px" width="100px">
                            <h2>Dawoud Husain</h2>
                        </div>
                    </a>
                    <a href=<?php echo $url . "Team104/karanvir/" ?>>
                        <div class="team-member">
                            <img src="./Team104/karanvir/karanvir.jpeg" alt="Picture of Karanvir Basson " height="100px" width="100px">
                            <h2>Karanvir Basson</h2>
                        </div>
                    </a>
                    <a href=<?php echo $url . "Team104/john/" ?>>
                        <div class="team-member">
                            <img src="./Team104/john/john.jpg" alt="Picture of John Constantinides " height="100px" width="100px">
                            <h2>John Constantinides</h2>
                        </div>
                    </a>
                    <a href=<?php echo $url . "Team104/riley/" ?>>
                        <div class="team-member">
                            <img src="./Team104/riley/riley1.png" alt="Picture of Riley Deconkey" height="100px" width="100px">
                            <h2>Riley Deconkey</h2>
                        </div>
                    </a>
                    <a href=<?php echo $url . "Team104/thomas/" ?>>
                        <div class="team-member">
                            <img src="./Team104/thomas/thomas.jpg" alt="Picture of Thomas Phan" height="100px" width="100px">
                            <h2>Thomas Phan</h2>
                        </div>
                    </a>
                    <a href=<?php echo $url . "Team104/eason/" ?>>
                        <div class="team-member">
                            <img src="./Team104/eason/person1.jpeg" alt="Picture of Eason Liang" height="100px" width="100px">
                            <h2>Eason Liang</h2>
                        </div>
                    </a>
            </div>
        </section> 

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
