<?php

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$name = $_POST['name'] ?? '';
$nic = $_POST['nic'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$course = $_POST['course'] ?? '';
$address = $_POST['address'] ?? '';

// Validate input
if (empty($name) || empty($nic) || empty($telephone) || empty($course) || empty($address)) {
    header('Location: register.php?error=' . urlencode('All fields are required.'));
    exit();
}

try {
    // Check for duplicate NIC
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE nic = ?");
    $stmt->execute([$nic]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        header('Location: register.php?error=' . urlencode('A student with this NIC already exists.'));
        exit();
    }

    // Insert new student
    $stmt = $pdo->prepare("INSERT INTO students (name, nic, telephone, course, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $nic, $telephone, $course, $address]);

    header('Location: register.php?message=' . urlencode('Student registered successfully.'));
} catch (PDOException $e) {
    error_log('Registration error: ' . $e->getMessage());
    header('Location: register.php?error=' . urlencode('An error occurred while registering the student. Please try again.'));
}
exit();