<?php

// Assuming you have a database connection in $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Read input parameters
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phoneno = $_POST['phoneno'];
        $address = $_POST['address'];
        $age = $_POST['age'];
        $password = $_POST['password'];

        // Prepare SQL query
        $stmt = $pdo->prepare("UPDATE users SET name = ?, phoneno = ?, address = ?, age = ?, passcode = ? WHERE email = ? RETURNING *");
        $stmt->execute([$name, $phoneno, $address, $age, $password, $email]);

        // Fetch updated user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return updated user data as JSON
        header('Content-Type: application/json');
        echo json_encode($user);

    } catch (PDOException $e) {
        http_response_code(
