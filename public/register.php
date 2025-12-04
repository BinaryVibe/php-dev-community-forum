<?php
require "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = $_POST["first_name"];
    $last = $_POST["last_name"];
    $usernameInput = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users (first_name, last_name, username, email, password)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $first, $last, $usernameInput, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

    header("Location: login.html");

}
