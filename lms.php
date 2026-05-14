<?php
session_start();
require_once 'config/db.php';

// 1. Lock the door: check for faculty ID
if (!isset($_SESSION['faculty_id'])) { 
    header("Location: faculty-login.php"); 
    exit(); 
}

// 2. THE SAFETY NET: Safely check if the instructor_name exists in the session
$instructor_name = isset($_SESSION['instructor_name']) ? $_SESSION['instructor_name'] : "";

// 3. If they are using an old session that doesn't have the name, force a fresh login!
if (empty($instructor_name)) {
    session_destroy(); // Destroy the old memory
    header("Location: faculty-login.php"); // Send them back to the login page
    exit();
}

include 'includes/header.php'; 
?>

<div style="background-color: var(--primary); padding: 60px 20px; color: white; text-align: center;">
    <h1 style="margin: 0; font-size: 3rem;"><i class="fas fa-chalkboard-teacher"></i> Welcome, <?php echo htmlspecialchars($instructor_name); ?>!</h1>
    <p style="margin-top: 10px; font-size: 1.1rem;">Access your course modules and learning materials.</p>
</div>

<div class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px; min-height: 50vh;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h2 style="color: var(--primary); margin: 0; font-size: 1.8rem;">My Assigned Classes</h2>
        
        <div style="display: flex; align-items: center; gap: 15px;">
            <span style="border: 1px solid #ccc; padding: 8px 18px; border-radius: 20px; color: #555; font-size: 0.95rem; font-weight: bold;">
                Semester: 1st Sem 2025-2026
            </span>
            
            <a href="faculty-logout.php" style="background: #e74c3c; color: white; padding: 8px 18px; border-radius: 4px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: 0.2s;">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px;">
        
        <?php
        // THE FILTER: Only pull subjects where the instructor matches the logged-in teacher!
        $stmt = $pdo->prepare("SELECT * FROM subjects WHERE instructor = ? ORDER BY program, subject_code");
        $stmt->execute([$instructor_name]);
        
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                ?>
                <div style="background: white; border-radius: 8px; padding: 25px; border-top: 5px solid var(--primary); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    
                    <h3 style="color: var(--primary); margin-top: 0; margin-bottom: 10px; font-size: 1.4rem;">
                        <i class="fas fa-folder-open" style="margin-right: 8px;"></i> <?php echo htmlspecialchars($row['subject_code']); ?>
                    </h3>
                    
                    <p style="color: #444; font-weight: bold; font-size: 1rem; margin-bottom: 25px; height: 40px; overflow: hidden; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        <?php echo htmlspecialchars($row['subject_name']); ?>
                        <br>
                        <span style="font-size: 0.8rem; font-weight: normal; color: #888;">Program: <?php echo htmlspecialchars($row['program']); ?></span>
                    </p>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <div>
                            <p style="margin: 0; font-size: 0.95rem; font-weight: bold; color: #333;">Syllabus & Overview</p>
                            <small style="color: #888;">Status: Pending</small>
                        </div>
                        <button style="background: transparent; color: var(--primary); border: 1px solid var(--primary); padding: 5px 12px; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.2s;">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>

                </div>
                <?php
            }
        } else {
            echo "<p style='color: #888; font-size: 1.1rem; padding: 20px;'>You do not have any classes assigned to you for this semester.</p>";
        }
        ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>