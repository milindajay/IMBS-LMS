<?php

session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    exit(json_encode(['error' => 'Unauthorized']));
}

if (!isset($_POST['id'])) {
    exit(json_encode(['error' => 'Student ID is required']));
}

try {

    $stmt = $pdo->prepare("SELECT name FROM students WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    $student = $stmt->fetch();

    if (!$student) {
        exit(json_encode(['error' => 'Student not found']));
    }

    $stmt = $pdo->prepare("UPDATE students SET active = FALSE WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    echo json_encode([
        'success' => true,
        'message' => "Student " . htmlspecialchars($student['name']) . " has been deleted successfully."

    ]);
} catch (PDOException $e) {
    error_log('Delete error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while deleting the student. Please try again.']);
}