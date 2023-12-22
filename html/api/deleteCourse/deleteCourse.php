<?php

require_once "../db.php";
$pdo = getDatabaseConnection();

if ($pdo === null) {
    http_response_code(500);
    echo "Internal Server Error";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestBody = file_get_contents("php://input");
    $requestBody = json_decode($requestBody, true);

    try {
        $courseCodes = isset($requestBody -> courseCodes) ? $requestBody -> courseCodes : [];
        $courses = join(',', array_fill(0, count($courseCodes), '?'));

        $stmt = $pdo->prepare("DELETE FROM Course WHERE courseCode IN ($courses)");
        $stmt->execute($courseCodes);
    
        $deletedCount = $stmt->rowCount();
        echo "$deletedCount courses deleted successfully.";
        http_response_code(200);

    } catch (PDOException $e) {
        echo $e->getMessage();
        http_response_code(500);
    }
} else {
    http_response_code(405);
}

?>