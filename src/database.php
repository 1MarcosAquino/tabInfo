
<?php
/**
 * Connects to a MySQL database using PDO.
 *
 * @param string $dbName   The name of the database to connect to.
 * @param string $username The username for the database connection.
 * @param string $password The password for the database connection.
 * @return PDO|null        The PDO instance if connection is successful, or null on failure.
 */
function connectDatabase(string $dbName, string $username, string $password = ''): ?PDO
{
    try {
        $dsn = "mysql:host=localhost;dbname=$dbName;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch as associative arrays by default
            PDO::ATTR_PERSISTENT => true, // Enable persistent connections (optional)
        ];

        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        // Log the error (adjust the path to your log file as needed)
        error_log("Database connection error: " . $e->getMessage());

        // Display a generic message (do not expose sensitive details to users)
        die("Could not connect to the database. Please try again later.");
    }
}
