<?php
// Supabase Transaction Pooler (The only one that works with Vercel)
$host = "aws-0-ap-southeast-1.pooler.supabase.com"; 
$port = "6543"; 
$dbname = "postgres";
$user = "postgres.admvvhvycqzizzobvdie"; // This is the Pooler-specific username
$pass = "Donasco20021"; 

try {
    // Adding sslmode=require is necessary for the pooler connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$pass;sslmode=require";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
