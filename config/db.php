<?php
// Neon Postgres Connection - THE FINAL VERSION
$host = "ep-hidden-waterfall-a09a05x6-pooler.c-2.ap-southeast-1.aws.neon.tech";
$user = "neondb_owner";
$pass = "npg_5coPu4GOmBdD"; // This is the confirmed password from your screen
$dbname = "neondb";

try {
    // Standard Postgres connection string with SSL required by Neon
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$user;password=$pass;sslmode=require";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // When you refresh your site, your data will finally appear!
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
