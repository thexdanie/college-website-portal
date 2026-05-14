<?php
session_start();
require_once 'config/db.php';

// 1. Security Check (Using a dummy ID if session isn't set yet)
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : 1; 
$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;

if ($book_id > 0) {
    try {
        // 2. Mark book as Reserved in the catalog
        $stmt = $pdo->prepare("UPDATE library_resources SET status = 'Reserved' WHERE id = ?");
        $stmt->execute([$book_id]);

        // 3. Add the reservation to the logbook
        $stmt = $pdo->prepare("INSERT INTO library_reservations (student_id, resource_id) VALUES (?, ?)");
        $stmt->execute([$student_id, $book_id]);

        // --- THE FIX IS HERE ---
        // Change the location to library.php so you stay on your favorite design
        header("Location: library.php?status=success");
        exit();

    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // If something goes wrong, send them back to the main library page
    header("Location: library.php");
    exit();
}