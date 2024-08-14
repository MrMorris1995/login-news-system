<?php

// Include the database connection script and create a new Database object to establish a connection
require_once 'includes/db.php';
$database = new Database();
$conn = $database->getConnection();

// Check if an 'id' parameter is present in the URL query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Convert the 'id' to an integer to ensure it is a valid number

    // Create a query to select news with the specified ID
    $query = "SELECT * FROM news WHERE id = $id";
    $result = $conn->query($query);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch the news data as an associative array and return it as a JSON object with a success status
        $news = $result->fetch_assoc();
        echo json_encode(['success' => true, 'news' => $news]);
    } else {
        // Return an error message if no news item was found with the specified ID
        echo json_encode(['success' => false, 'error' => 'News not found.']);
    }
} else {
    // Return an error message if the 'id' parameter is missing from the query string
    echo json_encode(['success' => false, 'error' => 'Error.']);
}

// Close the database connection
$conn->close();

?>
