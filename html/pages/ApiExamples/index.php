<html>
    <head>
        <title>Web Api Examples</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    </head>
    <body>
    <a class="link" href="https://cis3760f23-04.socs.uoguelph.ca/"><h1 class = "groupNum">104</h1></a>
    <div class="homepageBody">
        <p class="homepageBodyTitle">Web Api</p>
        <p class="homepageBodyText">
            This page provides a direct interface to our api
            <br>
            <br>
        </p>

        <a style="color:white;margin-left: 180px;" href = "https://cis3760f23-04.socs.uoguelph.ca/ApiDoc/"target="_blank"> Click Here To View Documentation </a>
        
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">Load Courses from CSV</p>
                <div class = "downloadButton">
                    <form action="https://cis3760f23-04.socs.uoguelph.ca/api/loadcourses/loadcourses.php" method="POST">
                        <input type="submit" name='load' value="LOAD" class="dlButton">
                    </form>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">GET Example</p>
                <div class = "downloadButton">
                    <form action="" method="get">
                        <input type="submit" name='getCourse' value="GET" class="dlButton">
                        <input type="text" id="inputGET" placeholder="Course ID" name="getCourseID">
                        <input type="text" id="inputGET" placeholder="Course Name" name="getCourseName">
                        <input type="text" id="inputGET" placeholder="Course Description" name = "description">
                        <input type="text" id="inputGET" placeholder="Credit Amount" name = "getCredit">
                        <input type="text" id="inputGET" placeholder="Location" name = "location">
                        <input type="text" id="inputGET" placeholder="Restriction" name = "restriction">
                        <input type="text" id="inputGET" placeholder="Prerequisite" name = "preq">
                    </form>
                    <?php
                    $multTrigggered = false;
                    $queryParameters='';
                    // Check if courseid or name has been entered set query parameters based on that
                    if (isset($_GET['getCourse'])) {
                        $apiUrl = 'https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php';
                    if(isset($_GET ['getCourseID'])&& $_GET['getCourseID']!=''){
                        $queryParameters = $queryParameters.'id='.$_GET['getCourseID'];
                        $multTrigggered = true;
                    }
                    if(isset($_GET ['getCourseName'])&& $_GET['getCourseName']!=''){
                        if($multTrigggered==true){
                            $queryParameters = $queryParameters.'&';
                        }
                        $queryParameters= $queryParameters.'name='.$_GET['getCourseName'];
                        $nameTriggered= true;
                    }
                    if(isset($_GET ['description'])&&$_GET['description']!=''){
                        if($multTrigggered==true){
                            $queryParameters = $queryParameters.'&';
                        }
                        $queryParameters= $queryParameters.'description='.$_GET['description'];
                        $multTrigggered= true;
                    }
                    if(isset($_GET ['getCredit'])&&$_GET['getCredit']!=''){
                        if($multTrigggered==true){
                            $queryParameters = $queryParameters.'&';
                        }
                        $queryParameters= $queryParameters.'credit='.$_GET['getCredit'];
                        $multTrigggered= true;
                    }
                    if(isset($_GET ['location'])&& $_GET['location']!=''){
                        if($multTrigggered==true){
                            $queryParameters = $queryParameters.'&';
                        }
                        $queryParameters= $queryParameters.'location='.$_GET['location'];
                        $multTrigggered= true;
                    }
                    if(isset($_GET ['restriction'])&&$_GET['restriction']!=''){
                        if($multTrigggered==true){
                            $queryParameters = $queryParameters.'&';
                        }
                        $queryParameters= $queryParameters.'restriction='.$_GET['restriction'];
                        $multTrigggered= true;
                    }
                    if(isset($_GET ['preq'])&&$_GET['preq']!=''){
                        if($multTrigggered==true){
                            $queryParameters = $queryParameters.'&';
                        }
                        $queryParameters= $queryParameters.'preq='.$_GET['preq'];
                        $multTrigggered= true;
                    }
                        // Make the response using curl 
                        $apiUrl = $apiUrl.'?'.$queryParameters;
                        $ch = curl_init($apiUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //Get the outpput in json
                        $response = curl_exec($ch);
                        $code = curl_getinfo($ch,CURLINFO_RESPONSE_CODE);
                        curl_close($ch);
                        // Check if valid response
                        if($code != 200){
                            echo "No Results Found 1 ".$code;
                            exit;
                        }
                        // decode to a array similar to python 
                        $obj = json_decode($response,true);
                        // // Print out all the course names
                        if(count($obj)==0){
                            echo "No Results Found 2 ";
                        }else{
                            foreach ($obj as $course){
                                echo $course['courseCode'].' '.$course['courseName'].'<br>';
                            }
                        }

                    }
 
                    ?>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">PUT Example</p>
                <div class = "downloadButton">
                    <form action="" method="put">
                        <input type="submit" name='putCourse' value="PUT" class="dlButton">
                        <input type="text" id="inputPUT" name="putparam">
                    </form>
                    <?php
                    if (isset($_PUT['putCourse'])) {
                        //code to send put request

                        //echo a status message for success or failure
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">POST Example 1</p>
                <div class = "downloadButton">
                    <form action="" method="post" style="padding-10px;" id="insertForm">
                        <h2>Add a Course</h2>
                        Course code: <input name="code" type="text" maxlength=20 required> 
                        Course name: <input name="name" type="text" required> 
                        Course description: <input name="desc" type="text"> </br>
                        Course credit: <input name="credits" type="number" step="0.25" min="0" value="0" required> 
                        Course location: <input name="location" type="text"> 
                        Enter course restrictions: <input name="restrictions" type="text"> 
                        <br> Add prerequisites: <br>
                        1. <input name="prereq1" type="text"> 
                         2. <input name="prereq2" type="text"> 
                         3. <input name="prereq3" type="text">  
                         4. <input name="prereq4" type="text">  </br>
                         5. <input name="prereq5" type="text">  
                         6. <input name="prereq6" type="text"> 
                         7. <input name="prereq7" type="text">  
                        </br> <input type="submit" name='postCourse' value="ADD" class="dlButton">
                    </form>
                    <?php
                        $formData = array();
                        
                        if(isset($_POST['code']) && $_POST['code'] != '') {
                            formData["courseCode"] = $_POST['code'];
                        }

                        if(isset($_POST['name']) && $_POST['name'] != '') {
                            formData["courseName"] = $_POST['name'];
                        }
                        //cannnot contain spaces
                        if(isset($_POST['desc']) && $_POST['desc'] != '') {
                            formData["courseDesc"] = $_POST['desc'];
                        }

                        if(isset($_POST['credits']) && $_POST['credits'] > 0) {
                            formData["credits"] = $_POST['credits'];
                        }

                        if(isset($_POST['location']) && $_POST['location'] != '') {
                            formData["location"] = $_POST['location'];
                        }

                        if(isset($_POST['restrictions']) && $_POST['restrictions'] != '') {
                            formData["restrictions"] = $_POST['restrictions'];
                        }

                        $jsonData = json_encode($formData);

                        // make POST request with cURL
                        $ch = curl_init();
                        $url = "https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php";

                        // set request options
                        curl_setopt($ch, CURLOPT_URL, $url); // set url
                        curl_setopt($ch, CURLOPT_POST, true); // set request type
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // set request body
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response as string 
                        
                        // execute query
                        $res = curl_exec($ch);
                        $resCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                        // $resMsg = curl_getinfo($ch, CURLINFO_HEADER_OUT);

                        if($e = curl_error($ch)) {
                            echo $e;
                        } 
                        //echo $resCode;
                        curl_close($ch);
                    ?>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">DELETE Example</p>
                <div class = "downloadButton">
                    <form action="" method="post">
                        <input type="submit" name='deleteCourse' value="DELETE" class="dlButton">
                        <input type="text" id="inputDELETE" name="deleteparam">
                    </form>
                    <?php

                        if (isset($_POST['deleteCourse'])) {
                            //echo 'test';
                            $courseCode = $_POST['deleteparam'];
                            $url = "https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?courseCode=" . $courseCode;

                            $opts = array(
                                'http' => array(
                                    'method' => 'DELETE',
                                ),
                            );
                            $context = stream_context_create($opts);
                            $result = file_get_contents($url, false, $context);
                            echo $result;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
