<?php
require_once "../db.php";

try {
    $pdo = getDatabaseConnection();
    if ($pdo === null) {
        http_response_code(500);
        echo "Internal Server Error";
        exit;
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        // echo 'testing';
        $courseCodes = $data['coursesTaken'] ?? [];
        if(count($courseCodes)>0){
            array_push($courseCodes,'credit','average');
        }
        $placeholders = implode(',', array_fill(0, count($courseCodes), '?')); // Create a list of placeholders for prepared statement
        $credit = $data['credits'];
        $grade = $data['average'];
        if (!empty($courseCodes)) {
            // First Query: Fetch data based on multiple LIKE clauses for Description
            $firstQuery = "SELECT DISTINCT * FROM Prerequisite NATURAL JOIN Course WHERE Description LIKE ?";
            for ($i = 1; $i < count($courseCodes); $i++) {
                $firstQuery .= " OR Description LIKE ?";
            }

            $stmt1 = $pdo->prepare($firstQuery);

            // Bind the course codes to the placeholders with a wildcard for LIKE
            foreach ($courseCodes as $index => $code) {
                $stmt1->bindValue($index + 1, "%$code%");
            }

            $stmt1->execute();
            $firstData = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            if(!$firstData){
                echo json_encode($firstData);
                http_response_code(200);
                exit;
            }

            // Process the results of the first query
            $secondCourseCodes = array_column($firstData, 'courseCode');
            $secondCourseCodes = array_unique($secondCourseCodes);
            $secondCourseCodes = array_values($secondCourseCodes);
            
            // Manually escape and quote each course code for safe inclusion in the query
            foreach ($secondCourseCodes as $key => $code) {
                $secondCourseCodes[$key] = $pdo->quote($code);
            }
            
            // Construct the query with the course codes directly included
            $courseCodesForSql = implode(", ", $secondCourseCodes);
            $secondQuery = "SELECT courseCode, description FROM Prerequisite NATURAL JOIN Course WHERE courseCode IN ($courseCodesForSql)";
            
            $stmt2 = $pdo->prepare($secondQuery);
            $stmt2->execute();
            $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            $tree = [];
            // echo json_encode($rows);
            foreach($rows as $row) {
                $courseCode = $row['courseCode'];
                $description = $row['description'];

                if (!isset($tree[$courseCode])) $tree[$courseCode] = [];
                array_push($tree[$courseCode], $description);
            }

            $possibleCourses = [];

            foreach($tree as $course => $prerequisites){
                $isMatch = TRUE;
                foreach ($prerequisites as $prerequisite){
                    $prerequisite = preg_replace('/\s+/', ' ', trim($prerequisite));

                    if (preg_match('/(\d+) of/', $prerequisite, $matches)) {
                        // get the "n" from n of
                        $numberRequired = $matches[1];
                        // echo json_encode($matches);
                        $count = 0;
                        // get the prerequisites and put into an array
                        $options = explode(',', substr($prerequisite, strlen($matches[0])));
                        $options = array_map('trim', $options); // Trim each option
                        $intersect = array_intersect($options, $courseCodes);
                        if(count($intersect) < $numberRequired){
                            $isMatch = FALSE;
                            break;
                        }
                   
                    }else if(preg_match('/(\d+)%/',$prerequisite,$matches)){
                        
                        if($grade < (float)$matches[1]){
                            $isMatch = FALSE;
                            break;
                        }
                    }else if (preg_match('/\b(\d+(\.\d+)?)\s*(?:credit|credits)\b/i',$prerequisite,$matches)){
                        if($credit < (float)$matches[1]){
                            $isMatch = FALSE;
                            break;
                        }
                    }else {
                        //if a single course then check if it is in course codes
                        if(!in_array($prerequisite,$courseCodes)){
                            $isMatch = FALSE;
                            break;
                        }
                    }
                }
                if($isMatch){
                    array_push($possibleCourses,$course);
                }
                $isMatch = TRUE;
            }
            if(count($possibleCourses) > 0){
                $courses= join(',', array_fill(0, count($possibleCourses), '?'));
                $stmt3 = $pdo->prepare("SELECT * FROM Course WHERE courseCode IN ($courses)");
                $stmt3->execute($possibleCourses);
                $rows = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            }
            else{
                $rows = [];
            }
            //maybe call to get the rest of the information?
            echo json_encode($rows);

        } else {
        
            $query = "SELECT * from Course left join Prerequisite on Course.courseCode = Prerequisite.courseCode WHERE Prerequisite.description = '';";
            $stmt = $pdo->prepare($query);

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // echo $query;
            echo json_encode($rows);
            http_response_code(200);
        }


    }   
} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);
}