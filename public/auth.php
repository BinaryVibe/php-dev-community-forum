<?php
session_start();
require "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = $_POST["identifier"];
    $password = $_POST["password"];

    $sql = "SELECT user_id, username, password, email FROM users WHERE email = '$identifier' OR username = '$identifier' LIMIT 1";

    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            die();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        echo "<script>
            alert('An account with this email or username does not exist.');
            window.location.href = 'login.html';
        </script>";
    }
}