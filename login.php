<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username and password values submitted via the POST request
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Include the database connection script, create a new Database object, and establish a connection to the database
    require_once 'includes/db.php';
    $database = new Database();
    $conn = $database->getConnection();

    // Prepare a SQL statement to select all columns from the 'users' table where the username matches a placeholder.
    // Bind the username parameter to the placeholder, execute the statement, and fetch the result as an associative array.
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if a user was found and if the provided password matches the hashed password in the database.
    // If both conditions are true, store the username in the session and redirect to the admin page. 
    // Otherwise, set an error message indicating invalid login credentials.
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: admin.php");
        exit;
    } else {
        $error = "Wrong Login Data!";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="images/logo.svg" alt="Logo" class="logo">
            <form action="login.php" method="post">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
        </div>
    </div>
</body>
</html>