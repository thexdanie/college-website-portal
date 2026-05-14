<?php 
require_once 'config/db.php';
include 'includes/header.php'; 
?>

<section class="container" style="padding: 60px 0;">
    <h1 class="heading-font" style="text-align: center; margin-bottom: 40px;">Campus News & Announcements</h1>
    
    <div class="grid">
        <?php
        // Fetch all announcements from the database
        $stmt = $pdo->query("SELECT * FROM announcements ORDER BY posted_at DESC");
        while ($row = $stmt->fetch()) {
            // Format the date nicely
            $date = date("F j, Y", strtotime($row['posted_at']));
            
            echo "
            <div class='card' style='display: flex; flex-direction: column;'>
                <small style='color: var(--accent); font-weight: bold; margin-bottom: 10px;'>{$row['category']}</small>
                <h3 style='margin-bottom: 10px;'>{$row['title']}</h3>
                <p style='color: var(--muted); font-size: 0.9rem; margin-bottom: 15px;'><i class='far fa-calendar-alt'></i> {$date}</p>
                <p style='flex-grow: 1;'>" . substr($row['content'], 0, 120) . "...</p>
                <div style='margin-top: 20px;'>
                    <a href='news-detail.php?id={$row['id']}' class='btn btn-primary' style='padding: 8px 15px; font-size: 0.9rem;'>Read Full Story</a>
                </div>
            </div>";
        }
        ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>