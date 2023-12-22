<?php

header("Content-Type: application/json");
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400"); // 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

exit(0);
}

require_once "../db.php";
$pdo = getDatabaseConnection();

if ($pdo === null) {
    http_response_code(500);
    echo "Internal Server Error";
    exit;
}

// Check what request is being made or else return error 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = json_decode(file_get_contents("php://input"));

    $conditions = [];
    $parameters = [];

    $findPrequisites = FALSE;

    // Check through each to see what query parameters we have and build the query 
    if (isset($requestBody -> preq)) {
        $preq = $requestBody -> preq;
        if($preq){
            $findPrequisites = TRUE;
        }
    }
    
    foreach (['id' => 'courseCode', 'name' => 'courseName', 'description' => 'courseDesc', 'credit' => 'credits', 'location' => 'location', 'restriction' => 'restriction'] as $key => $field) {
        if (isset($requestBody->$key)) {
            if ($key === 'credit') {
                $conditions[] = "$field = :$key";
                $parameters[$key] = $requestBody->$key;
            } else {
                $conditions[] = "$field LIKE :$key";
                $parameters[$key] = '%' . $requestBody->$key . '%';
            }
        }
    }
    
    // Create select query with conditions if there are any
    $query = "SELECT * FROM Course";
    if (!empty($conditions)) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }
    
    try {
        header("Content-Type: application/json");
        $statement = $pdo->prepare($query);
        $statement->execute($parameters);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        if($findPrequisites){
            // Fetching prerequisites from the correct table
            $prereqQuery = "SELECT courseCode, description FROM Prerequisite";
            $prereqStatement = $pdo->query($prereqQuery);
            $allPrereqs = $prereqStatement->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // Mapping prerequisites to courses
        foreach ($results as $key => $course) {
            $prerequisites = [];
            $hasValidPrereq = false; // check if any valid prereqs
            
            if($findPrequisites){
                foreach ($allPrereqs as $prereq) {
                    if ($prereq['courseCode'] === $course['courseCode']) {
                        if (!empty(trim($prereq['description']))) {
                            $prerequisites[] = $prereq['description'];
                            $hasValidPrereq = true; // Valid prerequisite found
                        }
                    }
                }
            
                // Set prerequisites to null if no valid prerequisite is found
                $results[$key]['prerequisites'] = $hasValidPrereq ? $prerequisites : null;
            }
        }
    
        echo json_encode($results);
        http_response_code(200);
    } catch (PDOException $e) {
        echo $e->getMessage();
        http_response_code(500);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $courses = json_decode(file_get_contents('php://input'), true);

    
    $updatedCount = 0;
    $isUpdated = false;
    
    try {
        foreach($courses as $data){
            $code = $data["courseCode"];
            $name = $data["courseName"];
            $desc = $data["courseDesc"];
            $credit = $data["credits"];
            $location = $data["location"];
            
            // Assuming courseCode is the primary key or unique identifier
            $courseCode = $data["courseCode"];
            
            // Prepare the SQL statement with placeholders
            $query = "UPDATE Course 
                    SET courseCode = :code, courseName = :name, courseDesc = :desc, credits = :credit, location = :location 
                    WHERE courseCode = :courseCode";

            // connect to db - comment this
            // $pdo = new PDO($dsn, $user, $password);
            
            $statement = $pdo->prepare($query);
        
            // Binding the parameters
            $statement->bindParam(':code', $code);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':desc', $desc);
            $statement->bindParam(':credit', $credit);
            $statement->bindParam(':location', $location);
            $statement->bindParam(':courseCode', $courseCode);

            // execute statement
            $statement->execute();

            if($statement->rowCount() > 0){
                $isUpdated = true;
            }
            if(isset($data["prerequisites"])){
                $deletePrerequisiteQuery = "DELETE FROM Prerequisite WHERE courseCode = :courseCode";
                $deleteStatement = $pdo->prepare($deletePrerequisiteQuery);
                $deleteStatement->bindParam(':courseCode', $code);
                $deleteStatement->execute();

                if ($deleteStatement->rowCount() > 0) {
                    $isUpdated = true;
                }

                $insertPrerequisiteQuery = "INSERT INTO Prerequisite (courseCode, description) VALUES (:courseCode, :description)";
                $insertStatement = $pdo->prepare($insertPrerequisiteQuery);

                foreach ($data["prerequisites"] as $prerequisite) {
                    $insertStatement->bindParam(':courseCode', $code);
                    $insertStatement->bindParam(':description', $prerequisite);
                    $insertStatement->execute();
                    if ($insertStatement->rowCount() > 0) {
                        $isUpdated = true;
                    }
                }
            }
            // If either course details or its prerequisites were updated, increase the counter
            if ($isUpdated) {
                $updatedCount++;
            }
    
        }
        header("Content-Type: text/plain");
        echo $updatedCount . " courses updated.";
        http_response_code(200);

    } catch(Exception $e) {
        echo 'Exception occured: ' . $e->getMessage();
        http_response_code(500);
    } 

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $courseCodes = json_decode(file_get_contents('php://input'), true);
    
    if (empty($courseCodes)) {
        echo "No course codes provided.";
        http_response_code(400);
        exit;
    } 

    $courses= join(',', array_fill(0, count($courseCodes), '?'));
    $stmt = $pdo->prepare("DELETE FROM Course WHERE courseCode IN ($courses)");

    $stmt->execute($courseCodes);
    

    $deletedCount = $stmt->rowCount();

    $deleteStatement = $pdo->prepare("DELETE FROM Prerequisite WHERE courseCode IN ($courses)");
    $deleteStatement->execute($courseCodes);
    
    if ($deletedCount > 0) {
        echo "$deletedCount courses deleted successfully.";
    } else {
        echo "No courses found with the provided course code(s).";
    }
    http_response_code(200);
}
else {
    http_response_code(405); // Method Not Allowed
}
?>
