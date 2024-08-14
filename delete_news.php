<?php
session_start();
header('Content-Type: application/json');

// Initialize a response array with a default success status of false
$response = ['success' => false];

// Check if a user session is not set; if not, return an authorization error message and terminate the script
if (!isset($_SESSION['user'])) {
    $response['error'] = 'Not authorized.';
    echo json_encode($response);
    exit;
}

// Process the request if it is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db.php';  // Include the database connection script
    $database = new Database();
    $conn = $database->getConnection();  // Establish a database connection

    // Retrieve the ID from the POST request, default to an empty string if not set
    $id = $_POST['id'] ?? '';

    // Check if the ID is provided
    if ($id) {
        // Prepare and execute an SQL statement to delete the news entry with the specified ID
        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param('i', $id);

        // Check if the deletion was successful
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['error'] = 'Error while deleting news!';  // Set an error message if deletion fails
        }

        $stmt->close();  // Close the statement
    } else {
        $response['error'] = 'ID is required!';  // Set an error message if ID is missing
    }

    $conn->close();  // Close the database connection
} else {
    $response['error'] = 'Invalid request method!';  // Set an error message for invalid request methods
}

// Return the response as a JSON object
echo json_encode($response);
