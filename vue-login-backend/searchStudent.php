<?php
require __DIR__ . '/vendor/autoload.php';
include 'Cors.php';
require 'db.php';  
require 'validate.php';

session_start();
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (empty($authHeader)) {
    $headers = apache_request_headers();
    $authHeader = $headers['Authorization'] ?? '';
}

if (empty($authHeader)) {
    echo json_encode(['success' => false, 'error' => 'Authorization token missing or malformed']);
    exit;
}
if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    echo json_encode(['success' => false, 'error' => 'Authorization token malformed']);
    exit;
}

$jwt = $matches[1];
$userId = validateJWT($jwt);
if (!$userId) {
    echo json_encode(['success' => false, 'error' => 'Invalid token']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $params = $_GET;
    $whereClauses = [];
    $queryParams = [];

    if (isset($params['query'])) {
        $searchQuery = "%" . $params['query'] . "%";
        $whereClauses[] = "(firstname LIKE :query OR lastname LIKE :query)";
        $queryParams[':query'] = $searchQuery;
    }
    if (isset($params['email'])) {
        $whereClauses[] = "email LIKE :email";
        $queryParams[':email'] = "%" . $params['email'] . "%";
    }
    if (empty($whereClauses)) {
        echo json_encode(['success' => false, 'error' => 'No search query or email provided']);
        exit;
    }
    try {
        $sql = "SELECT * FROM users WHERE " . implode(' OR ', $whereClauses) . " LIMIT 10";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($queryParams);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($students) {
            echo json_encode(['success' => true, 'students' => $students]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No students match your search criteria']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
}

?>

