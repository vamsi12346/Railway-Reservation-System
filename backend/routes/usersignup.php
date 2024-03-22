<?php
require_once "db_connection.php"; // Assuming 'db_connection.php' includes the connection to the PostgreSQL database

// Assuming this code is within a file handling the user signup endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $age = $data['age'];
    $phoneno = $data['phoneno'];
    $address = $data['address'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    
    if ($stmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, passcode,age,phoneno,address) VALUES (:name, :email, :password, :age, :phoneno, :address)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password, 'age' => $age, 'phoneno' => $phoneno, 'address' => $address]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user);
    } else {
        http_response_code(401);
        echo "Email already exists";
    }
} else {
    echo "Method not allowed";
}
?>
