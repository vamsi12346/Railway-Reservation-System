<?php

// Assuming you have a database connection in $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Read input parameters
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare SQL query
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Check if user exists
        if (!$user) {
            http_response_code(401);
            echo "Invalid Email";
            exit;
        }

        // Check if password is correct
        if ($user['passcode'] !== $password) {
            http_response_code(401);
            echo "Invalid Password";
            exit;
        }

        // Return user data as JSON
        header('Content-Type: application/json');
        echo json_encode($user);

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Server Error";
        exit;
    }
}

?>
