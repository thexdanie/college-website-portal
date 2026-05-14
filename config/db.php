<?php
// Railway automatically provides these environment variables
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

try {
    // This is the DSN (Data Source Name) string for PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    
    // Create the $pdo variable your index.php is looking for
    $pdo = new PDO($dsn, $user, $pass);
    
    // Set error mode to exceptions so you can see problems in the Railway logs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
    
    // Optional: set default fetch mode to Associative Array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // If connection fails, this will show up in your Railway logs
    error_log("Connection failed: " . $e->getMessage());
    die("Internal Server Error");
}
?>
