<?php
session_start();

// Check if the user session is not set; if not, redirect to the login page and stop further script execution
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Retrieve the success message from the session if it exists; otherwise, set an empty string. Then, remove the success message from the session.
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

// Include the database connection script, create a new Database object, and establish a connection to the database
require_once 'includes/db.php';
$database = new Database();
$conn = $database->getConnection();

// Execute a query to select all news items from the database, ordered by the creation date in descending order. 
// Then, get the number of rows returned by the query.
$news_result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
$news_count = $news_result->num_rows;
$news_result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
$news_count = $news_result->num_rows;

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Bereich</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <div class="admin-container">
        <img src="images/logo.svg" alt="Logo" class="logo">
        <div id="messages">
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
        </div>
        <?php if ($news_result->num_rows > 0): ?>
            <h2 id="news-heading">All News</h2>
            <ul id="news-list">
                <?php while ($news = $news_result->fetch_assoc()): ?>
                <li class="news-item" data-id="<?php echo $news['id']; ?>">
                    <div class="news-item-text">
                        <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                        <p><?php echo implode(' ', array_slice(explode(' ', $news['content']), 0, 20)); ?>...</p>
                    </div>
                    <div class="news-item-actions">
                        <button class="edit-button" data-id="<?php echo $news['id']; ?>"></button>
                        <button class="delete-button" data-id="<?php echo $news['id']; ?>"></button>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>        
        <div id="create-news">
            <h2 id="form-header">Create News</h2>
            <form id="create-form" method="POST" action="create_news.php">
                <div class="input-group">
                    <input type="text" name="title" placeholder="Titel" required>
                </div>
                <div class="input-group">
                    <textarea name="content" placeholder="Description" required></textarea>
                </div>
                <button type="submit" class="create-button">Create</button>
            </form>
        </div>
        <div id="edit-news" class="hidden">
            <h2 id="edit-heading">Edit News</h2>
            <form id="edit-form" method="POST" action="update_news.php">
                <input type="hidden" name="id" id="edit-id">
                <div class="input-group">
                    <input type="text" name="title" id="edit-title" placeholder="Titel" required>
                </div>
                <div class="input-group">
                    <textarea name="content" id="edit-content" placeholder="Inhalt" required></textarea>
                </div>
                <button type="submit" class="create-button">Save</button>
            </form>
        </div>
        <button id="logout-button" class="logout-button" onclick="logout()">Logout</button>
    </div>
</body>
</html>
