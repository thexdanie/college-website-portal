<?php 
require_once 'config/db.php';
include 'includes/header.php'; 

$message_status = '';

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $program = htmlspecialchars($_POST['program_interest']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into database securely
    try {
        $stmt = $pdo->prepare("INSERT INTO inquiries (full_name, email, program_interest, message) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $program, $message])) {
            $message_status = "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>Thank you, $name! Your inquiry has been sent successfully.</div>";
        }
    } catch (PDOException $e) {
        $message_status = "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>Error submitting form. Please try again.</div>";
    }
}
?>

<section class="container" style="padding: 60px 0; max-width: 800px;">
    <h1 class="heading-font" style="text-align: center; margin-bottom: 30px;">Get in Touch</h1>
    
    <?php echo $message_status; ?>

    <div class="card">
        <form method="POST" action="contact.php">
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Full Name</label><br>
                <input type="text" name="full_name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid var(--border); border-radius: 4px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Email Address</label><br>
                <input type="email" name="email" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid var(--border); border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Program of Interest</label><br>
                <select name="program_interest" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid var(--border); border-radius: 4px;">
                    <option value="">-- Select a Program --</option>
                    <?php
                    // Dynamically populate the dropdown with programs from the database
                    $prog_stmt = $pdo->query("SELECT name FROM programs");
                    while ($p = $prog_stmt->fetch()) {
                        echo "<option value='{$p['name']}'>{$p['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold;">Message</label><br>
                <textarea name="message" rows="5" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid var(--border); border-radius: 4px;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Inquiry</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>