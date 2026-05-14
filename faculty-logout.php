<?php
session_start();

// Destroy all session variables (faculty_id, instructor_name, etc.)
session_unset();
session_destroy();

// Teleport them back to the main homepage
header("Location: index.php");
exit();
?>