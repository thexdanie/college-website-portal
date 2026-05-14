<?php
// Neon Postgres Connection (The Final Victory Code)
$host = "ep-hidden-waterfall-a09a05x6.c-2.ap-southeast-1.aws.neon.tech";
$user = "neondb_owner";
$pass = "npg_5coPu4GOmBdD"; 
$dbname = "neondb";

try {
    // Port 5432 works perfectly with Neon and Vercel!
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$user;password=$pass;sslmode=require";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // If you see your website data, it means we won!
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
