<?php
require_once "../db.php";

try {
	$pdo = getDatabaseConnection();

    if ($pdo === null) {
        http_response_code(500);
        echo "Internal Server Error";
        exit;
    }

    $pdo->exec("CREATE DATABASE IF NOT EXISTS courses");
    $pdo->exec("USE courses");
    $pdo->exec("DROP TABLE IF EXISTS Prerequisite;");
    $pdo->exec("DROP TABLE IF EXISTS Course;");
    $pdo->exec("CREATE TABLE IF NOT EXISTS Course (
        courseCode VARCHAR(20) PRIMARY KEY,
        courseName TEXT,
        courseDesc TEXT,
        credits TEXT,
        location TEXT,
        restrictions TEXT
    );");

    // CREATE PREREQUISITE TABLE
    $pdo->exec("CREATE TABLE IF NOT EXISTS Prerequisite (
        courseCode VARCHAR(20),
        description TEXT,
        FOREIGN KEY (courseCode) REFERENCES Course(courseCode)
        ON DELETE CASCADE
    );");

    $file = fopen('./courses.csv', "r"); // Load courses.csv file
    
    while ($line = fgets($file)) { // For each line
        if (empty($line)) continue; // If line is empty, continue
        
        $fields = explode(",", $line); // Split by fields in line

        $courseCode = addslashes(trim($fields[0])); // Get courseCode
        $courseName = addslashes(trim(str_replace('|', ',', $fields[1]))); // Get courseName
        $courseDescription = addslashes(trim(str_replace('|', ',', $fields[2]))); // Get courseDescription
        $courseCredits = addslashes(trim($fields[3])); // Get courseCredits
        $courseLocation = addslashes(trim($fields[4])); // Get courseLocation
        $courseRestrictions = addslashes(trim(str_replace('|', ',', $fields[5]))); // Get courseRestrictions
        $coursePrerequisites = array_slice($fields, 6); // Get coursePrerequisites

        // INSERT ROW INTO COURSE
        $pdo->exec("INSERT INTO Course VALUES (
            '$courseCode',
            '$courseName',
            '$courseDescription',
            '$courseCredits',
            '$courseLocation',
            '$courseRestrictions'
        );");

        foreach($coursePrerequisites as $coursePrerequisite) { // For each coursePrerequisite
            $coursePrerequisite = addslashes(trim(str_replace('|', ',', $coursePrerequisite))); // Remove csv formatting from coursePrerequisite
            
            // INSERT ROW INTO PREREQUISITE
            $pdo->exec("INSERT INTO Prerequisite VALUES (
                '$courseCode',
                '$coursePrerequisite'
            );");
        }
    }
    
    fclose($file);
    echo "Courses Successfully loaded!";

} catch (PDOException $e) {
	echo $e->getMessage();
}
?>
