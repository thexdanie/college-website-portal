<?php
// Neon Connection - FINAL PRODUCTION VERSION
$host = "ep-hidden-waterfall-a09a05x6-pooler.c-2.ap-southeast-1.aws.neon.tech";
$user = "neondb_owner";
$pass = "npg_5coPu4GOmBdD"; 
$dbname = "neondb";

try {
    // Port 5432 is correct for the Neon Pooler
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$user;password=$pass;sslmode=require";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful!
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
