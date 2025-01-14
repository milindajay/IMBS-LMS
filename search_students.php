<?php

session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit(json_encode(['error' => 'Unauthorized']));
}

function performSearch($pdo, $search)
{
    $suggest = isset($_POST['suggest']) ? true : false;

    try {
        $searchTerm = preg_replace('/\s*$$[^)]*$$/', '', $search);
        $searchTerm = trim($searchTerm);

        $stmt = $pdo->prepare("SELECT * FROM students WHERE (nic LIKE :search OR name LIKE :search) AND active = TRUE LIMIT 10");
        $stmt->execute(['search' => "%$searchTerm%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($suggest) {
            $suggestions = [];
            foreach ($results as $row) {
                $suggestions[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'nic' => $row['nic'],
                    'address' => $row['address'],
                    'display' => $row['name'] . ' (' . $row['nic'] . ')'
                ];
            }
            echo json_encode(['success' => true, 'suggestions' => $suggestions]);
        } else {
            if (count($results) > 0) {
                $html = '<div class="overflow-x-auto">';
                $html .= '<table class="min-w-full divide-y divide-gray-200">';
                $html .= '<thead class="bg-gray-50">';
                $html .= '<tr>';
                $html .= '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIC</th>';
                $html .= '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>';
                $html .= '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>';
                $html .= '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>';
                $html .= '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>';
                $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody class="bg-white divide-y divide-gray-200">';

                foreach ($results as $row) {
                    $html .= '<tr>';
                    $html .= '<td class="px-6 py-4 whitespace-nowrap text">' . htmlspecialchars($row['nic']) . '</td>';
                    $html .= '<td class="px-6 py-4 whitespace-nowrap text">' . htmlspecialchars($row['name']) . '</td>';
                    $html .= '<td class="px-6 py-4 whitespace-nowrap text">' . htmlspecialchars($row['course']) . '</td>';
                    $html .= '<td class="px-6 py-4 whitespace-nowrap text">' . htmlspecialchars($row['address']) . '</td>';
                    $html .= '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">';
                    $html .= '<a href="edit.php?id=' . $row['id'] . '" class="rounded-md bg-green-800 text-white px-3.5 py-2.5 hover:bg-green-900 mr-4">Edit</a>';
                    $html .= '<a href="delete.php?id=' . $row['id'] . '" class="border px-3.5 py-2.5 rounded-md hover:bg-red-600 hover:text-white border-red-600 text-red-600 hover:text-red-700">Delete</a>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }

                $html .= '</tbody>';
                $html .= '</table>';
                $html .= '</div>';

                echo json_encode(['success' => true, 'html' => $html]);
            } else {
                echo json_encode(['success' => true, 'html' => '<p class="text-gray-500">No results found.</p>']);
            }
        }
    } catch (PDOException $e) {
        error_log('Search error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'An error occurred while searching. Please try again.']);
    }
}


if (isset($_POST['query'])) {
    $search = trim($_POST['query']);
    $searchTerm = preg_replace('/\s*$$[^)]*$$/', '', $search);
    $searchTerm = trim($searchTerm);

    $results = performSearch($pdo, $searchTerm);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request. Please provide a search query.']);
}