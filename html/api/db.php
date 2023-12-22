<?php
function getDatabaseConnection() {
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $isProdEnv = str_contains($url, 'cis3760f23-04.socs.uoguelph.ca');
    
    $user = $isProdEnv ? 'cis3760' : 'root';
    $password = $isProdEnv ? 'pass1234' : '';
    $dsn = "mysql:host=localhost;dbname=courses";
    
    try {
        $pdo = new PDO($dsn, $user, $password);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        echo $e->getMessage();
        return null;
    }
}
?>