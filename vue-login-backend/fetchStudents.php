<?php
include 'Cors.php';
require __DIR__ . '/vendor/autoload.php';
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Missing session user_id']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'student'");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'students' => $students]);
} catch (PDOException $e) {
    error_log("Error fetching students: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error fetching students']);
}
?>
