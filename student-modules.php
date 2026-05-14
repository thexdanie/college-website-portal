<?php 
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['student_id'])) { 
    header("Location: student-login.php"); 
    exit(); 
}

$student_id = $_SESSION['student_id'];

// 1. GET STUDENT PROGRAM (e.g., BSIT)
$stmt = $pdo->prepare("SELECT program FROM students WHERE student_id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

// 2. FETCH MODULES matching the student's program
// We join 'modules' with 'subjects' so we only show modules for the student's course (like BSIT)
$modStmt = $pdo->prepare("
    SELECT m.*, s.subject_name 
    FROM modules m 
    JOIN subjects s ON m.course_code = s.subject_code 
    WHERE s.program = ?
    ORDER BY m.date_uploaded DESC
");
$modStmt->execute([$student['program']]);
$modules = $modStmt->fetchAll();

include 'includes/header.php'; 
?>

<section style="padding: 60px 20px; background: #fbfbfd; min-height: 90vh;">
    <div class="container">
        
        <div style="margin-bottom: 30px;">
            <a href="student-dashboard.php" style="text-decoration: none; color: #0071e3; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <h1 style="font-weight: 800; margin-bottom: 40px; color: #1d1d1f; letter-spacing: -0.02em;">Learning Modules</h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
            <?php if(count($modules) > 0): ?>
                <?php foreach($modules as $m): ?>
                    <div class="card" style="padding: 30px; border-top: 4px solid #5856d6;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                            <span style="background: rgba(88, 86, 214, 0.1); color: #5856d6; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                                <?php echo htmlspecialchars($m['course_code']); ?>
                            </span>
                            <i class="fas fa-file-pdf" style="color: #ff3b30; font-size: 1.2rem;"></i>
                        </div>
                        
                        <h3 style="margin: 0 0 5px 0; font-size: 1.2rem; color: #1d1d1f;"><?php echo htmlspecialchars($m['module_title']); ?></h3>
                        <p style="color: #86868b; font-size: 0.9rem; margin-bottom: 25px;"><?php echo htmlspecialchars($m['subject_name']); ?></p>
                        
                        <a href="uploads/<?php echo $m['file_name']; ?>" class="btn" download style="display: block; text-align: center; text-decoration: none; padding: 12px; font-weight: 600;">
                            <i class="fas fa-download"></i> Download Module
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card" style="padding: 50px; text-align: center; grid-column: 1 / -1;">
                    <i class="fas fa-folder-open" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                    <p style="color: #86868b; font-size: 1.1rem;">No modules found for your program (<?php echo $student['program']; ?>) yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>