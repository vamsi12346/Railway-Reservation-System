<?php
require_once "db_connection.php"; // Assuming 'db_connection.php' includes the connection to the PostgreSQL database

// Assuming this code is within a file handling the endpoint to view all trains
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM trainsinfo ORDER BY id ASC");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} else {
    echo "Method not allowed";
}
?>
