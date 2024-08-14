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

    // Retrieve ID, title, and content from the POST request, default to empty strings if not set
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    // Check if ID, title, and content are provided
    if ($id && $title && $content) {
        // Prepare and execute an SQL statement to update the news entry with the specified ID
        $stmt = $conn->prepare("UPDATE news SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param('ssi', $title, $content, $id);

        // Check if the update was successful
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'News successfully updated!';  // Set a success message in the session
            $response['success'] = true;
        } else {
            $response['error'] = 'Error while updating news.';  // Set an error message if the update fails
        }

        $stmt->close();  // Close the statement
    } else {
        $response['error'] = 'Title, description, and ID are required!';  // Set an error message if any required fields are missing
    }

    $conn->close();  // Close the database connection
} else {
    $response['error'] = 'Invalid request method!';  // Set an error message for invalid request methods
}

// Return the response as a JSON object
echo json_encode($response);

