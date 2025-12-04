<?php
session_start();
require "../config/config.php";
// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to create a post.");
}

$user_id = $_SESSION['user_id'];


if ($conn->connect_errno) {
    die("Failed to connect to MySQL: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $body = trim($_POST["body"]);

    // Insert
    $stmt = $conn->prepare("
        INSERT INTO posts (user_id, title, body)
        VALUES (?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iss", $user_id, $title, $body);



    // Redirect to the specfic post created. Use show_page.php
    if ($stmt->execute()) {
        // echo "<script>alert('Success')</script>";
        header("Location: show_post.php?id=". $conn->insert_id);
        exit;
    } else {
        echo "<script>alert('Error')</script>";

        header("Location: new_post.php");
        exit;
    }
}
