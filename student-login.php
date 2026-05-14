<?php 
session_start();
require_once 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim removes accidental spaces at the start or end
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);

    try {
        // Double check: Is your column name 'student_id' in phpMyAdmin?
        $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch();

        if ($student) {
            // Student found! Now checking password...
            // Checking both plain text and encrypted just to be safe while you test
            if ($password === $student['password'] || password_verify($password, $student['password'])) { 
                $_SESSION['student_id'] = $student['student_id'];
                $_SESSION['student_name'] = $student['first_name'] . ' ' . $student['last_name'];
                header("Location: student-dashboard.php");
                exit();
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "No student found with ID: " . htmlspecialchars($student_id);
        }
    } catch(PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
include 'includes/header.php'; 
?>

<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; background: #fbfbfd;">
    <div class="card" style="width: 100%; max-width: 450px; padding: 50px 40px; text-align: center; border-top: 4px solid #0071e3;">
        
        <i class="fas fa-user-graduate" style="font-size: 3.5rem; color: #0071e3; margin-bottom: 20px;"></i>
        <h1 style="font-size: 2rem; color: #1d1d1f; margin-bottom: 10px; letter-spacing: -0.02em;">Student Portal</h1>
        <p style="color: #86868b; margin-bottom: 30px;">Sign in to view your grades, schedules, and modules.</p>

        <?php if($error): ?>
            <div style="color: #ff3b30; background: rgba(255,59,48,0.1); padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid rgba(255,59,48,0.2);">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" style="text-align: left;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1d1d1f; font-size: 0.95rem;">Student ID</label>
                <input type="text" name="student_id" required style="width: 100%; box-sizing: border-box;" placeholder="e.g. 2026-0001">
            </div>

            <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <label style="font-weight: 600; color: #1d1d1f; font-size: 0.95rem;">Password</label>
                    <a href="#" style="color: #0071e3; font-size: 0.85rem; text-decoration: none; font-weight: 500;">Forgot password?</a>
                </div>
                <input type="password" name="password" required style="width: 100%; box-sizing: border-box; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.1); padding: 14px; background-color: rgba(255, 255, 255, 0.8);">
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 16px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                Sign In
            </button>
        </form>

        <div style="margin-top: 30px; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 20px;">
            <p style="font-size: 0.9rem; margin: 0;">New student? <a href="apply.php" style="color: #0071e3; text-decoration: none; font-weight: 600;">Apply for Admission</a></p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>