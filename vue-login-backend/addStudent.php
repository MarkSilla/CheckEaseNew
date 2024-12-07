<?php
include 'Cors.php';  
require __DIR__ . '/vendor/autoload.php';  
include 'db.php'; 
include 'validate.php';

session_start();  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['student_id'], $data['class_id'], $data['status'])) {
        $attendance_date = date('Y-m-d H:i:s'); 

        $stmt = $pdo->prepare("SELECT id FROM users WHERE id = :student_id");
        $stmt->execute([':student_id' => $data['student_id']]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            $stmt = $pdo->prepare("INSERT INTO attendance (student_id, class_id, attendance_date, status) 
                                   VALUES (:student_id, :class_id, :attendance_date, :status)");
            $stmt->execute([
                ':student_id' => $data['student_id'],
                ':class_id' => $data['class_id'],
                ':attendance_date' => $attendance_date,
                ':status' => $data['status']
            ]);
            echo json_encode([
                "message" => "Attendance record created successfully.", 
                "attendance_id" => $pdo->lastInsertId()
            ]);
        } else {

            echo json_encode(["message" => "Student not found."]);
        }
    } else {
        echo json_encode(["message" => "Invalid input data"]);
    }
}
?>
