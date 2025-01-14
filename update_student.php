<?php

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE students SET nic = ?, name = ?, address = ?, telephone = ?, course = ? WHERE id = ?");
    $stmt->execute([
        $_POST['nic'],
        $_POST['name'],
        $_POST['address'],
        $_POST['telephone'],
        $_POST['course'],
        $_POST['id']
    ]);

    if ($stmt->rowCount() > 0) {
        header('Location: edit.php?id=' . $_POST['id'] . '&message=' . urlencode('Student information updated successfully.'));
    } else {
        header('Location: edit.php?id=' . $_POST['id'] . '&error=' . urlencode('No changes were made or student not found.'));
    }
} catch (PDOException $e) {
    error_log('Update error: ' . $e->getMessage());
    header('Location: edit.php?id=' . $_POST['id'] . '&error=' . urlencode('An error occurred while updating the student information.'));
}