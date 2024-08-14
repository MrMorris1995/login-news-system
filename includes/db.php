<?php
// Define a Database class to manage database connections.
class Database {
    private $host = 'localhost';          // Database host
    private $db_name = 'database_cgrd';   // Database name
    private $username = 'root';            // Database username
    private $password = '';                // Database password
    public $conn;                          // Property to hold the database connection

    // Method to establish and return a database connection
    public function getConnection() {
        $this->conn = null;

        try {
            // Create a new mysqli instance to connect to the database
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            // Check if the connection was successful
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Output error message and stop script execution if connection fails
            echo $e->getMessage();
            exit;
        }

        // Return the database connection object
        return $this->conn;
    }
}

?>
