<?php
// Include database connection
require_once '../php/connect.php'; // Adjust the path if necessary

// Set response type to JSON
header('Content-Type: application/json');

// Fetch all guest sessions from the database
$query = "SELECT * FROM guest_sessions";
$stmt = $pdo->query($query);

// Check if query was successful
if ($stmt) {
    // Fetch all rows as an associative array
    $guest_sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result as a JSON response
    echo json_encode($guest_sessions);
} else {
    // If the query failed, return an error message
    echo json_encode(['error' => 'Failed to fetch guest sessions.']);
}
