<?php
// Supabase Connection (PostgreSQL)
$host = "db.admvvhvycqzizzobvdie.supabase.co"; 
$port = "6543"; // Using 6543 for the 'Express Lane' connection
$dbname = "postgres";
$user = "postgres";
$pass = "Donasco20021"; 

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$pass";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Success!
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
