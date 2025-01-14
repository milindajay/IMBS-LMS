<?php

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

try {
    // Fetch active students
    $stmt = $pdo->prepare("SELECT name, nic, course, created_at FROM students WHERE active = TRUE ORDER BY created_at DESC");
    $stmt->execute();
    $activeStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch deleted students
    $stmt = $pdo->prepare("SELECT name, nic, course, created_at FROM students WHERE active = FALSE ORDER BY created_at DESC");
    $stmt->execute();
    $deletedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode([
        'active' => $activeStudents,
        'deleted' => $deletedStudents
    ]);
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while fetching student data.']);
}