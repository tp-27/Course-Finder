<?php
require_once "../db.php";

try {
    $pdo = getDatabaseConnection();
    if ($pdo === null) {
        http_response_code(500);
        echo "Internal Server Error";
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $data = json_decode(file_get_contents("php://input"), true);
        $courseCodes = $data['courseCodes'] ?? [];

        if (empty($courseCodes)) {
            echo "No course codes provided.";
            http_response_code(400);
            exit;
        }

        $courses= join(',', array_fill(0, count($courseCodes), '?'));
        $stmt = $pdo->prepare("DELETE FROM Course WHERE courseCode IN ($courses)");

        $stmt->execute($courseCodes);

        $deletedCount = $stmt->rowCount();
        if ($deletedCount > 0) {
            echo "$deletedCount courses deleted successfully.";
        } else {
            echo "No courses found with the provided course codes.";
        }
        http_response_code(200);
    }   
} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);
}
?>