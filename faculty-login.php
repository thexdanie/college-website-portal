<?php 
$pageTitle = "Faculty LMS Login | BCC Inc.";
require_once 'config/db.php';
session_start();

$error = "";

// --- THE LOGIN LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_id = $_POST['faculty_id']; // This is what they typed in the ID box
    $password = $_POST['password'];

    // 1. Search for the faculty member by their Faculty ID or Username
    $stmt = $pdo->prepare("SELECT * FROM faculty WHERE faculty_id = ? OR username = ?");
    $stmt->execute([$input_id, $input_id]);
    $faculty = $stmt->fetch();

    if ($faculty) {
        // 2. Check if the password matches
        // It checks BOTH hashed (secure) and plain text (for your older test accounts)
        if (password_verify($password, $faculty['password']) || $password === $faculty['password']) {
            
            // 3. SUCCESS: Set the session and go to dashboard
            $_SESSION['faculty_id'] = $faculty['faculty_id'];
            $_SESSION['faculty_name'] = $faculty['full_name'];
            
            header("Location: faculty-dashboard.php");
            exit();
        } else {
            $error = "The password you entered is incorrect.";
        }
    } else {
        $error = "No account found with that Faculty ID or Username.";
    }
}

include 'includes/header.php'; 
?>

<section style="min-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; background: #fbfbfd;">
    
    <div class="card" style="width: 100%; max-width: 420px; padding: 50px 40px; text-align: center; border-top: 5px solid #0071e3; position: relative; overflow: hidden;">
        
        <div style="position: absolute; top: -50px; left: -50px; width: 100px; height: 100px; background: rgba(0, 113, 227, 0.1); filter: blur(40px); border-radius: 50%;"></div>

        <i class="fas fa-chalkboard-teacher" style="font-size: 3.5rem; color: #0071e3; margin-bottom: 25px; filter: drop-shadow(0 4px 10px rgba(0,113,227,0.2));"></i>
        
        <h1 style="font-size: 2.2rem; color: #1d1d1f; margin-bottom: 8px; font-weight: 800; letter-spacing: -0.03em;">Faculty LMS</h1>
        <p style="color: #86868b; margin-bottom: 35px; font-weight: 500; font-size: 1.05rem;">Manage your classes and curriculum.</p>

        <?php if($error): ?>
            <div style="color: #ff3b30; background: rgba(255,59,48,0.08); padding: 14px; border-radius: 14px; margin-bottom: 25px; font-size: 0.9rem; font-weight: 600; border: 1px solid rgba(255,59,48,0.1);">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" style="text-align: left;">
            <div style="margin-bottom: 22px;">
                <label style="display: block; margin-bottom: 10px; font-weight: 700; color: #1d1d1f; font-size: 0.9rem; margin-left: 5px;">Faculty ID or Username</label>
                <input type="text" name="faculty_id" required 
                       style="width: 100%; box-sizing: border-box; font-size: 1rem;" 
                       placeholder="e.g. FAC-2026-01">
            </div>

            <div style="margin-bottom: 35px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; margin-left: 5px;">
                    <label style="font-weight: 700; color: #1d1d1f; font-size: 0.9rem;">Password</label>
                    <a href="#" style="color: #0071e3; font-size: 0.85rem; text-decoration: none; font-weight: 600;">Forgot?</a>
                </div>
                <input type="password" name="password" required 
                       style="width: 100%; box-sizing: border-box; font-size: 1rem;" 
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 18px; font-size: 1.1rem; font-weight: 700; letter-spacing: -0.01em; box-shadow: 0 10px 25px rgba(0,113,227,0.25);">
                Sign In to Portal
            </button>
        </form>

        <div style="margin-top: 35px; border-top: 1px solid rgba(0,0,0,0.06); padding-top: 25px;">
            <p style="font-size: 0.95rem; margin: 0; color: #86868b; font-weight: 500;">
                Need assistance? Contact <a href="index.php#contact" style="color: #0071e3; text-decoration: none; font-weight: 700;">Support</a>
            </p>
        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>