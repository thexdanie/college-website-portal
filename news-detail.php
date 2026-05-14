<?php 
require_once 'config/db.php';

// Check if an ID was passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: news.php"); // Send them back to news if no ID is found
    exit;
}

$id = $_GET['id'];

// Securely fetch the specific announcement
$stmt = $pdo->prepare("SELECT * FROM announcements WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

// If article doesn't exist in DB, redirect
if (!$article) {
    header("Location: news.php");
    exit;
}

include 'includes/header.php'; 
?>

<section class="container" style="padding: 60px 0; max-width: 800px;">
    <a href="news.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">&larr; Back to News</a>
    
    <div class="card" style="margin-top: 20px; padding: 40px;">
        <small style="background: var(--accent); color: var(--primary); padding: 5px 10px; border-radius: 4px; font-weight: bold;">
            <?php echo htmlspecialchars($article['category']); ?>
        </small>
        
        <h1 class="heading-font" style="margin: 20px 0;">
            <?php echo htmlspecialchars($article['title']); ?>
        </h1>
        
        <p style="color: var(--muted); margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <i class="far fa-calendar-alt"></i> Posted on: <?php echo date("F j, Y", strtotime($article['created_at'])); ?>
        </p>
        
        <div style="line-height: 1.8; font-size: 1.1rem;">
            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>