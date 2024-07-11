<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate session token against database
try {
    $conn = new PDO("mysql:host=localhost;dbname=applicant-records", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve session token from database for current user
    $stmt = $conn->prepare("SELECT session_token FROM adminaccount WHERE adminID = :adminID");
    $stmt->bindParam(':adminID', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if session token in database matches session token in $_SESSION
    if (!$result || $result['session_token'] !== $_SESSION['session_token']) {
        // Invalid session, destroy session and redirect to login page
        session_destroy();
        header("Location: login.php?alert=session_conflict");
        exit();
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>