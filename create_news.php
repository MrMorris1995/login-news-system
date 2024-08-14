<?php
session_start();
header('Content-Type: application/json');

// Initialize a response array with a default success status of false
$response = ['success' => false];

// Check if a user session is not set; if not, return an error message and terminate the script
if (!isset($_SESSION['user'])) {
    $response['error'] = 'Not authorized.';
    echo json_encode($response);
    exit;
}

// Process the request if it is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db.php';  // Include database connection script
    $database = new Database();
    $conn = $database->getConnection();  // Establish a database connection

    // Retrieve title and content from POST request, default to empty strings if not set
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    // Check if both title and content are provided
    if ($title && $content) {
        // Prepare and execute an SQL statement to insert news into the database
        $stmt = $conn->prepare("INSERT INTO news (title, content) VALUES (?, ?)");
        $stmt->bind_param('ss', $title, $content);

        // Check if the insertion was successful
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'News successfully created!';  // Set a success message in the session
            $response['success'] = true;
        } else {
            $response['error'] = 'Error while creating news!';  // Set an error message if insertion fails
        }

        $stmt->close();  // Close the statement
    } else {
        $response['error'] = 'Title and content are required!';  // Set an error message if title or content is missing
    }

    $conn->close();  // Close the database connection
} else {
    $response['error'] = 'Invalid request method!';  // Set an error message for invalid request methods
}

// Return the response as a JSON object
echo json_encode($response);
