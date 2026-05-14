<?php 
require_once 'config/db.php';
include 'includes/header.php'; 

$msg = "";
$status = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $program = $_POST['program'];
    
    // 1. Check if the 'uploads' folder exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // 2. File Upload Logic
    $target_dir = "uploads/";
    $file_extension = pathinfo($_FILES["report_card"]["name"], PATHINFO_EXTENSION);
    $file_name = time() . "_" . str_replace(' ', '_', $name) . "." . $file_extension; 
    $target_file = $target_dir . $file_name;

    // 3. Move file and save to database
    if (move_uploaded_file($_FILES["report_card"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO applications (full_name, email, program_choice, document_path) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $program, $file_name])) {
            $msg = "Application submitted! Our registrar will review your documents soon.";
            $status = "success";
        }
    } else {
        $msg = "Error: Could not upload your document. Please check file size.";
        $status = "error";
    }
}
?>

<section class="container" style="padding: 80px 20px; max-width: 700px; margin: auto;">
    <div class="card" style="border-top: 5px solid var(--primary); padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h2 class="heading-font" style="color: var(--primary); margin-bottom: 10px;">BCC Online Application</h2>
        <p style="color: var(--muted); margin-bottom: 30px;">Ready to join us? Upload your requirements below.</p>

        <?php if($msg): ?>
            <div style="background: <?php echo ($status == 'success') ? '#d4edda' : '#f8d7da'; ?>; 
                        color: <?php echo ($status == 'success') ? '#155724' : '#721c24'; ?>; 
                        padding: 15px; border-radius: 5px; margin-bottom: 25px;">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:bold; margin-bottom: 5px;">Complete Name</label>
                <input type="text" name="full_name" placeholder="Juan Dela Cruz" required style="width:100%; padding:12px; border:1px solid var(--border); border-radius:4px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:bold; margin-bottom: 5px;">Active Email Address</label>
                <input type="email" name="email" placeholder="example@email.com" required style="width:100%; padding:12px; border:1px solid var(--border); border-radius:4px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:bold; margin-bottom: 5px;">Select Your Program</label>
                <select name="program" required style="width:100%; padding:12px; border:1px solid var(--border); border-radius:4px; background: white;">
                    <option value="" disabled selected>-- Select a Program --</option>
                    <option value="EDUC">Education (BSED & BEED)</option>
                    <option value="BSBA">BS Business Administration (HR & FM)</option>
                    <option value="BSA">BS Accountancy (BSA)</option>
                    <option value="BSIT">BS Information Technology (BSIT)</option>
                </select>
            </div>

            <div style="margin-bottom: 30px; background: #f8f9fa; padding: 20px; border: 2px dashed var(--border); border-radius: 8px;">
                <label style="display:block; font-weight:bold; margin-bottom: 10px;">Upload Report Card / PSA (PDF or Image)</label>
                <input type="file" name="report_card" required style="width:100%;">
                <small style="color: var(--muted); display: block; margin-top: 5px;">Maximum file size: 5MB</small>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:18px; font-weight:bold; font-size: 1.1rem;">
                <i class="fas fa-paper-plane"></i> Submit Application
            </button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>