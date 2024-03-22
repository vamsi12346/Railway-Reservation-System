<?php

// Assuming you have a database connection in $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Read input parameters
        $id = $_POST['id'];

        // Prepare SQL query
        $stmt = $pdo->prepare("SELECT * FROM trainsinfo WHERE id = ?");
        $stmt->execute([$id]);

        // Fetch data
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Server Error";
        exit;
    }
}

?>
