<?php
$pageTitle = "Inquire | BCC Inc.";
require_once 'config/db.php';
include 'includes/header.php';

$message = "";

// Check if a course was passed in the URL (e.g., from the Programs page)
$selected_course = isset($_GET['course']) ? $_GET['course'] : '';

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $student_message = $_POST['message'];

    try {
        // FIXED: Insert using your EXACT database column names (full_name, program_interest)
        $stmt = $pdo->prepare("INSERT INTO inquiries (full_name, email, program_interest, message, status) VALUES (?, ?, ?, ?, 'unread')");
        $stmt->execute([$name, $email, $course, $student_message]);
        
        $message = "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;'>
                        <i class='fas fa-paper-plane'></i> Thank you! Your inquiry has been sent to our Admissions team. We will email you shortly.
                    </div>";
    } catch(PDOException $e) {
        // If it fails, this will now show you the EXACT error from the database
        $message = "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;'>
                        <i class='fas fa-exclamation-triangle'></i> Database Error: " . $e->getMessage() . "
                    </div>";
    }
}
?>

<section style="background: var(--primary); color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 class="heading-font" style="margin: 0; font-size: 2.5rem;">Send an Inquiry</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; margin-top: 10px;">Have questions about BCC? Send us a message and we'll help you out.</p>
    </div>
</section>

<section class="container" style="padding: 60px 20px; min-height: 50vh; display: flex; justify-content: center;">
    
    <div style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); width: 100%; max-width: 600px; border-top: 5px solid var(--primary);">
        
        <?php echo $message; ?>

        <form method="POST" action="">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Program of Interest</label>
                <select name="course" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background: white;">
                    <option value="">-- Select a Program --</option>
                    <option value="BSBA" <?php echo ($selected_course == 'BSBA') ? 'selected' : ''; ?>>BS Business Administration (BSBA)</option>
                    <option value="BSA" <?php echo ($selected_course == 'BSA') ? 'selected' : ''; ?>>BS Accountancy (BSA)</option>
                    <option value="BSIT" <?php echo ($selected_course == 'BSIT') ? 'selected' : ''; ?>>BS Information Technology (BSIT)</option>
                    <option value="BSED" <?php echo ($selected_course == 'BSED') ? 'selected' : ''; ?>>Teacher Education (EDUC)</option>
                    <option value="Other">Other / General Inquiry</option>
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Your Message / Question</label>
                <textarea name="message" required rows="5" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <button type="submit" style="width: 100%; padding: 15px; background: var(--primary); color: white; border: none; border-radius: 4px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: 0.3s;">
                Submit Inquiry
            </button>
        </form>
    </div>

</section>

<?php include 'includes/footer.php'; ?>