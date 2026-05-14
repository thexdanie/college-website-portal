<?php 
session_start();
require_once 'config/db.php';

// 1. SECURITY
if (!isset($_SESSION['faculty_id'])) { 
    header("Location: faculty-login.php"); 
    exit(); 
}

$faculty_name = $_SESSION['faculty_name']; 
$message = "";

// --- 2. FETCH SUBJECTS ASSIGNED TO THIS INSTRUCTOR ---
// UPDATED: Now looks at 'subjects' table instead of 'class_schedules'
try {
    $subStmt = $pdo->prepare("
        SELECT subject_code, subject_name 
        FROM subjects 
        WHERE UPPER(TRIM(instructor)) = UPPER(TRIM(?))
    ");
    $subStmt->execute([$faculty_name]);
    $my_subjects = $subStmt->fetchAll();
} catch (PDOException $e) {
    $my_subjects = [];
}

// --- 3. HANDLE THE UPLOAD ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['module_file'])) {
    $course_code = $_POST['course_code'];
    $module_title = htmlspecialchars($_POST['module_title']);
    
    // Create uploads folder if it doesn't exist
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["module_file"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["module_file"]["tmp_name"], $target_file)) {
        // MATCHING YOUR DB COLUMNS: course_code, module_title, file_name
        $stmt = $pdo->prepare("INSERT INTO modules (course_code, module_title, file_name) VALUES (?, ?, ?)");
        if($stmt->execute([$course_code, $module_title, $file_name])) {
            $message = "<div style='background:#d4edda; color:#155724; padding:15px; border-radius:12px; margin-bottom:20px; font-weight:600;'>
                            <i class='fas fa-check-circle'></i> Success! Module published to students.
                        </div>";
        }
    } else {
        $message = "<div style='background:#f8d7da; color:#721c24; padding:15px; border-radius:12px; margin-bottom:20px;'>Error uploading file.</div>";
    }
}

include 'includes/header.php'; 
?>

<section style="padding: 60px 20px; background: #fbfbfd; min-height: 90vh;">
    <div class="container" style="max-width: 600px;">
        
        <div style="margin-bottom: 30px;">
            <a href="faculty-dashboard.php" style="text-decoration:none; color:#0071e3; font-weight:600;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="card" style="padding: 40px; border-top: 5px solid #0071e3;">
            <h2 style="margin-top:0; font-weight:800; color:#1d1d1f; letter-spacing:-0.02em;">
                <i class="fas fa-cloud-upload-alt" style="color:#0071e3;"></i> Module Uploader
            </h2>
            <p style="color:#86868b; margin-bottom:35px; font-weight:500;">Upload instructional materials for your assigned classes.</p>
            
            <?php echo $message; ?>

            <form method="POST" enctype="multipart/form-data">
                
                <div style="margin-bottom:25px;">
                    <label style="display:block; margin-bottom:10px; font-weight:700; color:#1d1d1f; font-size:0.9rem;">Module Title</label>
                    <input type="text" name="module_title" required 
                           placeholder="e.g. Week 1: Introduction to Data Analytics" 
                           style="width:100%; box-sizing:border-box; padding:14px; border-radius:10px; border:1px solid #ddd;">
                </div>

                <div style="margin-bottom:25px;">
                    <label style="display:block; margin-bottom:10px; font-weight:700; color:#1d1d1f; font-size:0.9rem;">Select Assigned Subject</label>
                    <select name="course_code" required 
                            style="width:100%; box-sizing:border-box; padding:14px; border-radius:10px; border:1px solid #ddd; background:white; font-size:1rem;">
                        
                        <?php if (count($my_subjects) > 0): ?>
                            <option value="">-- Choose Subject --</option>
                            <?php foreach($my_subjects as $s): ?>
                                <option value="<?php echo htmlspecialchars($s['subject_code']); ?>">
                                    <?php echo htmlspecialchars($s['subject_code'] . " - " . $s['subject_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No subjects found for your account</option>
                        <?php endif; ?>
                        
                    </select>
                    <?php if (count($my_subjects) == 0): ?>
                        <small style="color:#ff3b30; display:block; margin-top:8px; font-weight:600;">
                            <i class="fas fa-exclamation-triangle"></i> You have no assigned subjects in the system.
                        </small>
                    <?php endif; ?>
                </div>

                <div style="margin-bottom:35px;">
                    <label style="display:block; margin-bottom:10px; font-weight:700; color:#1d1d1f; font-size:0.9rem;">Upload File (PDF / Word / PPT)</label>
                    <div style="background:#f5f5f7; padding:20px; border-radius:12px; border:2px border-style:dashed; border-color:#d2d2d7; text-align:center;">
                        <input type="file" name="module_file" required style="font-size:0.9rem;">
                    </div>
                </div>

                <button type="submit" class="btn" style="width:100%; padding:18px; font-weight:700; font-size:1.1rem; box-shadow: 0 10px 20px rgba(0,113,227,0.2);">
                    Publish Module
                </button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>