<?php 
require_once 'config/db.php';
include 'includes/header.php'; 

$success_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['full_name']);
    $batch = $_POST['batch_year'];
    $job = htmlspecialchars($_POST['current_job']);
    $msg = htmlspecialchars($_POST['testimony']);

    $stmt = $pdo->prepare("INSERT INTO alumni (full_name, batch_year, current_job, testimony) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $batch, $job, $msg])) {
        $success_msg = "Thank you! Your story has been submitted for review.";
    }
}
?>

<section style="background: linear-gradient(rgba(0, 71, 171, 0.8), rgba(0, 71, 171, 0.8)), url('assets/images/campus.jpg') center/cover; padding: 100px 0; text-align: center; color: white;">
    <div class="container">
        <h1 class="heading-font" style="font-size: 3rem; margin-bottom: 10px;"><i class="fas fa-hand-holding-heart"></i> Alumni Network</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Connecting generations of BCC graduates across the globe.</p>
    </div>
</section>

<section class="container" style="padding: 80px 0;">
    <h2 class="heading-font" style="color: var(--primary); text-align: center; margin-bottom: 50px;">Alumni Wall of Fame</h2>
    
    <div class="grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM alumni ORDER BY batch_year DESC");
        while ($row = $stmt->fetch()) {
            echo "
            <div class='card' style='border-top: 4px solid var(--primary); text-align: center;'>
                <div style='width: 80px; height: 80px; background: var(--light); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;'>
                    <i class='fas fa-user-tie' style='font-size: 2rem; color: var(--primary);'></i>
                </div>
                <h3 style='margin-bottom: 5px; color: var(--text);'>{$row['full_name']}</h3>
                <small style='color: var(--primary); font-weight: bold; display: block; margin-bottom: 10px;'>Batch {$row['batch_year']}</small>
                <p style='font-weight: 600; color: var(--muted); font-size: 0.9rem; margin-bottom: 15px;'>{$row['current_job']}</p>
                <p style='font-style: italic; color: var(--text); font-size: 0.95rem;'>\"{$row['testimony']}\"</p>
            </div>";
        }
        ?>
    </div>
</section>

<section style="background-color: var(--light); padding: 80px 0;">
    <div class="container" style="max-width: 700px;">
        <div class="card" style="padding: 40px; border-top: 5px solid var(--primary);">
            <h2 class="heading-font" style="color: var(--primary); margin-bottom: 20px; text-align: center;">Join the Network</h2>
            <p style="text-align: center; color: var(--muted); margin-bottom: 30px;">Are you a BCC graduate? Share your success story with the next generation.</p>

            <?php if ($success_msg): ?>
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                    <?php echo $success_msg; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="alumni.php">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <input type="text" name="full_name" placeholder="Full Name" required style="padding: 12px; border: 1px solid var(--border); border-radius: 5px;">
                    <input type="number" name="batch_year" placeholder="Batch Year (e.g. 2015)" required style="padding: 12px; border: 1px solid var(--border); border-radius: 5px;">
                </div>
                <input type="text" name="current_job" placeholder="Current Job Title / Company" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 5px; margin-bottom: 20px; box-sizing: border-box;">
                <textarea name="testimony" placeholder="Your Success Story / Message to Students" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 5px; height: 120px; margin-bottom: 20px; box-sizing: border-box;"></textarea>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit My Story</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>