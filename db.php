<?php
// Supabase Connection (PostgreSQL)
$host = "admvvhvycqzizzobvdie.supabase.co"; 
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$pass = "Donasco20021"; // The password you created in Supabase

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$pass";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>