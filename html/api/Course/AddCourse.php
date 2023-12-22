<?php

require_once "../db.php";
$pdo = getDatabaseConnection();

if ($pdo === null) {
    http_response_code(500);
    echo "Internal Server Error";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // read raw input stream of POST request
    $requestBody = file_get_contents("php://input"); 

    // decode json string into PHP datatypes 
    $courseData = json_decode($requestBody); // echo json_encode($data[0]);

    // insert courses into db
    foreach($courseData as $course) {        
        // echo $course->courseCode;
        try {
            $query = "INSERT INTO Course (courseCode, courseName, courseDesc, credits, location, restrictions, prereq1,
                                            prereq2, prereq3, prereq4, prereq5, prereq6, prereq7)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // create prepared statement
            $statement = $pdo->prepare($query);

            // bind values
            $statement->bindParam(1, $course->courseCode, PDO::PARAM_STR);
            $statement->bindParam(2, $course->courseName, PDO::PARAM_STR);
            $statement->bindParam(3, $course->courseDesc, PDO::PARAM_STR);
            $statement->bindParam(4, $course->credits, PDO::PARAM_STR);
            $statement->bindParam(5, $course->locations, PDO::PARAM_STR);
            $statement->bindParam(6, $course->restrictions, PDO::PARAM_STR);
            $statement->bindParam(7, $course->prereq1, PDO::PARAM_STR);
            $statement->bindParam(8, $course->prereq2, PDO::PARAM_STR);
            $statement->bindParam(9, $course->prereq3, PDO::PARAM_STR);
            $statement->bindParam(10, $course->prereq4, PDO::PARAM_STR);
            $statement->bindParam(11, $course->prereq5, PDO::PARAM_STR);
            $statement->bindParam(12, $course->prereq6, PDO::PARAM_STR);
            $statement->bindParam(13, $course->prereq7, PDO::PARAM_STR);

            // execute statement
            $statement->execute();

            // check if row was added
            if ($statement->rowCount() > 0) {
                header("Content-Type: text/plain");
                echo "Success added: " . $course->courseCode;
                http_response_code(200);
            } else {
                header("Content-Type: text/plain");
                echo "Internal Server Error";
                http_response_code(500);
            }
        } catch(Exception $e) {
            echo 'Exception occured: ' . $e->getMessage();
            http_response_code(500);
        } 
    }
}