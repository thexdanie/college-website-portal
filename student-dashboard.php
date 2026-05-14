<?php 
session_start();
require_once 'config/db.php';

// 1. SECURITY: If not logged in, redirect to login
if (!isset($_SESSION['student_id'])) {
    header("Location: student-login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// 2. FETCH STUDENT INFO
$stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

$display_name = $student['first_name'] . " " . $student['last_name'];
$display_program = $student['program'] ?? "BCC Student";

// 3. FETCH GRADES (Joined with Subjects table)
$gradeStmt = $pdo->prepare("
    SELECT g.*, s.subject_name, s.subject_code 
    FROM grades g 
    JOIN subjects s ON g.subject_id = s.id 
    WHERE g.student_id = ?
");
$gradeStmt->execute([$student_id]);
$grades = $gradeStmt->fetchAll();

// --- 4. FETCH STUDENT BILLING (NEW DYNAMIC LOGIC) ---
$billStmt = $pdo->prepare("SELECT total_tuition, amount_paid FROM payments WHERE student_id = ?");
$billStmt->execute([$student_id]);
$payment = $billStmt->fetch();

if ($payment) {
    $total_tuition = $payment['total_tuition'];
    $amount_paid = $payment['amount_paid'];
    $balance = $total_tuition - $amount_paid;
} else {
    // Defaults if no record exists yet
    $balance = 0;
    $total_tuition = 0;
    $amount_paid = 0;
}

include 'includes/header.php'; 
?>

<section style="padding: 60px 20px; background: #fbfbfd; min-height: 90vh;">
    <div class="container">
        
        <div style="text-align: center; margin-bottom: 50px;">
            <h1 style="font-size: clamp(2rem, 4vw, 3rem); color: #1d1d1f; letter-spacing: -0.02em; margin-bottom: 10px; font-weight: 800;">
                Welcome back, <?php echo htmlspecialchars($display_name); ?>!
            </h1>
            <p style="color: #86868b; font-size: 1.1rem; font-weight: 500;">
                <i class="fas fa-id-card"></i> ID: <?php echo htmlspecialchars($student_id); ?> &nbsp;•&nbsp; 
                <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($display_program); ?>
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start;">
            
            <div class="card" style="padding: 30px; border-top: 4px solid #0071e3;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="font-size: 1.5rem; color: #1d1d1f; margin: 0; font-weight: 700;">
                        <i class="fas fa-file-alt" style="color: #0071e3;"></i> Academic Grades
                    </h2>
                    <button onclick="window.print()" class="btn" style="padding: 8px 20px; font-size: 0.9rem;">
                        <i class="fas fa-print"></i> Print Slip
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #f2f2f2; color: #86868b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 15px 10px;">Subject</th>
                                <th style="padding: 15px 10px; text-align: center;">Prelim</th>
                                <th style="padding: 15px 10px; text-align: center;">Midterm</th>
                                <th style="padding: 15px 10px; text-align: center;">Final</th>
                                <th style="padding: 15px 10px; text-align: center;">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($grades) > 0): ?>
                                <?php foreach ($grades as $g): 
                                    $s_name   = $g['subject_name'];
                                    $s_code   = $g['subject_code'];
                                    $s_prelim = $g['prelim_grade'];
                                    $s_mid    = $g['midterm_grade'];
                                    $s_final  = $g['final_rating'];

                                    // Remark Logic (1.0 - 5.0 System)
                                    if (empty($s_final) || strtoupper($s_final) == "INC") {
                                        $remark = "INC";
                                        $badge_color = "#ff9500"; 
                                    } else if (is_numeric($s_final) && $s_final <= 3.0) { 
                                        $remark = "PASSED";
                                        $badge_color = "#34c759"; 
                                    } else {
                                        $remark = "FAILED";
                                        $badge_color = "#ff3b30"; 
                                    }
                                ?>
                                <tr style="border-bottom: 1px solid #f2f2f2; font-size: 1.05rem; color: #1d1d1f;">
                                    <td style="padding: 20px 10px;">
                                        <div style="font-weight: 700; color: #1d1d1f;"><?php echo htmlspecialchars($s_name); ?></div>
                                        <div style="font-size: 0.8rem; color: #86868b;"><?php echo htmlspecialchars($s_code); ?></div>
                                    </td>
                                    <td style="padding: 20px 10px; text-align: center;"><?php echo $s_prelim ?: '—'; ?></td>
                                    <td style="padding: 20px 10px; text-align: center;"><?php echo $s_mid ?: '—'; ?></td>
                                    <td style="padding: 20px 10px; text-align: center; font-weight: 800; color: #0071e3;"><?php echo $s_final ?: '—'; ?></td>
                                    <td style="padding: 20px 10px; text-align: center;">
                                        <span style="background: <?php echo $badge_color; ?>; color: white; padding: 5px 12px; border-radius: 980px; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.02em;">
                                            <?php echo $remark; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding: 60px; text-align: center; color: #86868b;">
                                        <i class="fas fa-ghost" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                        No grades found for your account yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <div class="card" style="padding: 30px; text-align: center;">
                    <div style="background: <?php echo ($balance > 0) ? 'rgba(255, 59, 48, 0.1)' : 'rgba(52, 199, 89, 0.1)'; ?>; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-wallet" style="font-size: 1.5rem; color: <?php echo ($balance > 0) ? '#ff3b30' : '#34c759'; ?>;"></i>
                    </div>
                    <h3 style="font-size: 0.8rem; color: #86868b; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Balance Due</h3>
                    
                    <h2 style="font-size: 2.2rem; color: #1d1d1f; margin: 10px 0; font-weight: 700;">
                        ₱ <?php echo number_format($balance, 2); ?>
                    </h2>

                    <?php if ($balance > 0): ?>
                        <div style="margin-top: 5px;">
                            <span style="color: #ff3b30; font-size: 0.75rem; font-weight: 700; display: block; margin-bottom: 5px;">
                                <i class="fas fa-exclamation-circle"></i> PAYMENT REQUIRED
                            </span>
                            <small style="color: #86868b; font-size: 0.7rem;">Paid: ₱<?php echo number_format($amount_paid, 2); ?> / ₱<?php echo number_format($total_tuition, 2); ?></small>
                        </div>
                    <?php else: ?>
                        <span style="color: #34c759; font-size: 0.75rem; font-weight: 700;">
                            <i class="fas fa-check-circle"></i> ACCOUNT SETTLED
                        </span>
                    <?php endif; ?>
                </div>

                <div class="card" style="padding: 25px;">
                    <h3 style="font-size: 1rem; color: #1d1d1f; margin-bottom: 20px; font-weight: 700;">Quick Actions</h3>
                    
                    <a href="student-schedule.php" class="btn" style="display: block; text-align: center; margin-bottom: 12px; text-decoration: none; padding: 14px; font-size: 0.95rem;">
                        <i class="fas fa-calendar-alt"></i> &nbsp;View Class Schedule
                    </a>

                    <a href="student-modules.php" class="btn" style="display: block; text-align: center; margin-bottom: 12px; text-decoration: none; padding: 14px; font-size: 0.95rem; background: #5856d6 !important;">
                        <i class="fas fa-book"></i> &nbsp;Learning Modules
                    </a>
                    <p style="text-align: center; font-size: 0.75rem; color: #86868b; margin-top: -5px; margin-bottom: 15px;">Download PDF & Handouts</p>
                    
                    <a href="logout.php" style="display: block; text-align: center; color: #ff3b30; text-decoration: none; font-weight: 600; font-size: 0.9rem; margin-top: 15px;">
                        Sign Out of Portal
                    </a>
                </div>

            </div> </div> </div> </section>

<?php include 'includes/footer.php'; ?>