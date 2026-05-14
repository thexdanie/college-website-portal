<?php
// Supabase Connection (PostgreSQL)
$host = "db.admvvhvycqzizzobvdie.supabase.co"; 
$port = "6543"; // Using the pooler port for a faster connection
$dbname = "postgres";
$user = "postgres";
$pass = "Donasco20021"; // Make sure there are NO brackets [] here

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$pass";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful!
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
