<?php 
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty-login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];
$faculty_name = $_SESSION['faculty_name']; 

try {
    // UPDATED: Now looking at 'subjects' table as per your Admin code
    // We use TRIM and UPPER to ensure names match regardless of extra spaces or caps
    $subStmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM subjects 
        WHERE UPPER(TRIM(instructor)) = UPPER(TRIM(?))
    ");
    $subStmt->execute([$faculty_name]);
    $subject_count = $subStmt->fetchColumn();

    // Fetch the actual list from 'subjects'
    $listStmt = $pdo->prepare("
        SELECT * FROM subjects 
        WHERE UPPER(TRIM(instructor)) = UPPER(TRIM(?))
    ");
    $listStmt->execute([$faculty_name]);
    $my_classes = $listStmt->fetchAll();

} catch (PDOException $e) {
    $subject_count = 0;
    $my_classes = [];
}

include 'includes/header.php'; 
?>

<section style="padding: 60px 20px; background: #fbfbfd; min-height: 90vh;">
    <div class="container">
        
        <div style="margin-bottom: 50px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <h1 style="font-size: clamp(2rem, 4vw, 3rem); color: #1d1d1f; letter-spacing: -0.02em; margin-bottom: 10px; font-weight: 800;">
                    Hello, <?php echo htmlspecialchars($faculty_name); ?>!
                </h1>
                <p style="color: #86868b; font-size: 1.1rem; font-weight: 500;">
                    <i class="fas fa-id-badge"></i> Faculty ID: <?php echo htmlspecialchars($faculty_id); ?> &nbsp;•&nbsp; 
                    <span style="color: #34c759;"><i class="fas fa-circle" style="font-size: 0.6rem;"></i> System Online</span>
                </p>
            </div>
            <div style="padding-bottom: 10px;">
                <span style="background: white; padding: 10px 20px; border-radius: 980px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-weight: 600; font-size: 0.9rem;">
                    <?php echo date('F j, Y'); ?>
                </span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 40px;">
            
            <div class="card" style="padding: 30px; border-top: 4px solid #0071e3;">
                <i class="fas fa-book-open" style="font-size: 2rem; color: #0071e3; margin-bottom: 15px;"></i>
                <h3 style="color: #86868b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Assigned Subjects</h3>
                <h2 style="font-size: 2.5rem; margin: 10px 0; font-weight: 800;"><?php echo $subject_count; ?></h2>
                <a href="#load-table" style="color: #0071e3; text-decoration: none; font-size: 0.9rem; font-weight: 600;">View Load <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i></a>
            </div>

            <div class="card" style="padding: 30px; border-top: 4px solid #34c759;">
                <i class="fas fa-users" style="font-size: 2rem; color: #34c759; margin-bottom: 15px;"></i>
                <h3 style="color: #86868b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Active Students</h3>
                <h2 style="font-size: 2.5rem; margin: 10px 0; font-weight: 800;">--</h2>
                <p style="color: #86868b; font-size: 0.9rem; margin: 0;">Class list loading...</p>
            </div>

            <div class="card" style="padding: 30px; border-top: 4px solid #ff9500;">
                <i class="fas fa-file-signature" style="font-size: 2rem; color: #ff9500; margin-bottom: 15px;"></i>
                <h3 style="color: #86868b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Pending Grades</h3>
                <h2 style="font-size: 2.5rem; margin: 10px 0; font-weight: 800;">8</h2>
                <a href="#" style="color: #ff9500; text-decoration: none; font-size: 0.9rem; font-weight: 600;">Open Encoder <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i></a>
            </div>

        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
            <div class="card" style="padding: 35px;">
                <h3 style="margin-top: 0; margin-bottom: 25px; font-weight: 800;"><i class="fas fa-bolt" style="color: #ffcc00;"></i> Faculty Quick Actions</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <a href="faculty-upload-module.php" class="btn" style="text-align: center; padding: 15px; text-decoration: none; font-size: 0.9rem;">
                        <i class="fas fa-file-upload"></i> Upload Module
                    </a>
                    
                    <a href="faculty-online-class.php" class="btn" style="text-align: center; padding: 15px; text-decoration: none; font-size: 0.9rem; background: #333 !important;">
                        <i class="fas fa-video"></i> Start Online Class
                    </a>

                    <a href="faculty-research.php" class="btn" style="text-align: center; padding: 15px; text-decoration: none; font-size: 0.9rem; background: #5856d6 !important;">
                        <i class="fas fa-microscope"></i> Research Portal
                    </a>

                    <a href="logout.php" class="btn" style="text-align: center; padding: 15px; text-decoration: none; font-size: 0.9rem; background: #ff3b30 !important;">
                        <i class="fas fa-sign-out-alt"></i> Sign Out
                    </a>
                </div>
            </div>

            <div class="card" style="padding: 35px; background: rgba(0, 113, 227, 0.03) !important;">
                <h3 style="margin-top: 0; margin-bottom: 20px; font-weight: 800;"><i class="fas fa-bell" style="color: #0071e3;"></i> Admin Memo</h3>
                <div style="border-left: 3px solid #0071e3; padding-left: 20px;">
                    <p style="font-weight: 700; margin-bottom: 5px; color: #1d1d1f;">Final Grading Period</p>
                    <p style="font-size: 0.9rem; color: #86868b; line-height: 1.5;">Please ensure all Midterm grades are encoded by Friday. The system will lock at midnight.</p>
                </div>
            </div>
        </div>

        <div id="load-table" class="card" style="padding: 35px; border-top: 4px solid #5856d6;">
    <h3 style="margin-top: 0; margin-bottom: 25px; font-weight: 800;">
        <i class="fas fa-calendar-alt" style="color: #5856d6;"></i> My Official Teaching Load
    </h3>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #f2f2f2; color: #86868b; font-size: 0.8rem; text-transform: uppercase;">
                    <th style="padding: 15px;">Program</th>
                    <th style="padding: 15px;">Code</th>
                    <th style="padding: 15px;">Subject Name</th>
                    <th style="padding: 15px;">Schedule</th>
                    <th style="padding: 15px;">Room</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($my_classes) > 0): ?>
                    <?php foreach ($my_classes as $class): ?>
                    <tr style="border-bottom: 1px solid #f2f2f2; font-size: 1rem;">
                        <td style="padding: 15px; font-weight: 600;"><?php echo htmlspecialchars($class['program']); ?></td>
                        <td style="padding: 15px; font-weight: 700; color: #0071e3;"><?php echo htmlspecialchars($class['subject_code']); ?></td>
                        <td style="padding: 15px;"><?php echo htmlspecialchars($class['subject_name']); ?></td>
                        <td style="padding: 15px; font-weight: 600;"><?php echo htmlspecialchars($class['days_time'] ?: 'TBA'); ?></td>
                        <td style="padding: 15px;">
                            <span style="background: rgba(0,0,0,0.05); padding: 4px 10px; border-radius: 6px; font-size: 0.9rem;">
                                <?php echo htmlspecialchars($class['room'] ?: 'TBA'); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #86868b;">
                            No subjects found for "<?php echo htmlspecialchars($faculty_name); ?>". 
                            <br><small>Double-check the instructor assignment in the Admin panel.</small>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    </div> </section>

<?php include 'includes/footer.php'; ?>