<?php 
require_once 'config/db.php';
include 'includes/header.php'; 

// 1. Get Search or Course Filters
$search_query = isset($_GET['search']) ? trim($_GET['search']) : "";
$course_filter = isset($_GET['course']) ? trim($_GET['course']) : "";
?>

<section style="background: linear-gradient(rgba(0, 71, 171, 0.9), rgba(0, 71, 171, 0.9)), url('assets/images/campus.jpg') center/cover; padding: 80px 0; text-align: center; color: white;">
    <div class="container">
        <h1 class="heading-font" style="font-size: 3rem; margin-bottom: 10px;"><i class="fas fa-book-reader"></i> BCC Online Library</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Search our digital catalog of academic resources.</p>
        
        <form method="GET" action="library.php" style="margin-top: 30px; max-width: 600px; margin-left: auto; margin-right: auto; display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search by book title or author..." value="<?php echo htmlspecialchars($search_query); ?>" style="flex: 1; padding: 15px; border: none; border-radius: 5px; font-size: 1.1rem;">
            <button type="submit" class="btn btn-accent" style="padding: 15px 30px; font-size: 1.1rem;"><i class="fas fa-search"></i> Search</button>
        </form>

        <div style="margin-top: 25px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <a href="library.php" style="padding: 8px 18px; border: 1px solid white; color: white; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">All</a>
            <a href="library.php?course=BSIT" style="padding: 8px 18px; border: 1px solid white; color: white; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">BSIT</a>
            <a href="library.php?course=BSA" style="padding: 8px 18px; border: 1px solid white; color: white; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">BSA</a>
            <a href="library.php?course=BSBA" style="padding: 8px 18px; border: 1px solid white; color: white; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">BSBA</a>
            <a href="library.php?course=BSED" style="padding: 8px 18px; border: 1px solid white; color: white; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">BSED</a>
        </div>
    </div>
</section>

<section class="container" style="padding: 60px 0; min-height: 40vh;">
    
    <?php 
    // Title Logic with XSS Protection
    if ($search_query) {
        echo "<h3 style='color: var(--primary); margin-bottom: 20px;'>Search Results for \"".htmlspecialchars($search_query)."\"</h3>";
    } elseif ($course_filter) {
        echo "<h3 style='color: var(--primary); margin-bottom: 20px;'>" . htmlspecialchars($course_filter) . " Resources</h3>";
    } else {
        echo "<h3 style='color: var(--primary); margin-bottom: 20px;'>Recently Added Books</h3>";
    }
    ?>

    <div class="grid">
        <?php
        // Database Logic
        if ($search_query) {
            $stmt = $pdo->prepare("SELECT * FROM library_resources WHERE title LIKE ? OR author LIKE ? ORDER BY id DESC");
            $searchTerm = "%" . $search_query . "%";
            $stmt->execute([$searchTerm, $searchTerm]);
        } elseif ($course_filter) {
            $stmt = $pdo->prepare("SELECT * FROM library_resources WHERE category = ? ORDER BY id DESC");
            $stmt->execute([$course_filter]);
        } else {
            $stmt = $pdo->query("SELECT * FROM library_resources ORDER BY id DESC LIMIT 10");
        }

        if ($stmt->rowCount() > 0) {
            while ($book = $stmt->fetch()) {
                $statusColor = ($book['status'] == 'Available') ? '#27ae60' : '#e74c3c';
                $statusIcon = ($book['status'] == 'Available') ? 'fa-check-circle' : 'fa-times-circle';
                
                // Reserve Button logic
                if ($book['status'] == 'Available') {
                    $btn = "<a href='reserve-process.php?book_id={$book['id']}' class='btn btn-primary' style='padding: 5px 15px; font-size: 0.9rem; text-decoration: none;' onclick=\"return confirm('Reserve this book?')\">Reserve</a>";
                } else {
                    $btn = "<button class='btn' disabled style='padding: 5px 15px; font-size: 0.9rem; background: #ccc; border: none; cursor: not-allowed;'>Reserved</button>";
                }

                echo "
                <div class='card' style='border-top: 4px solid var(--primary);'>
                    <small style='background: var(--light); padding: 4px 8px; border-radius: 4px; color: var(--muted); font-weight: bold; display: inline-block; margin-bottom: 10px;'>".htmlspecialchars($book['category'])."</small>
                    <h3 style='margin-bottom: 5px; color: var(--text);'>".htmlspecialchars($book['title'])."</h3>
                    <p style='color: var(--muted); margin-bottom: 15px;'><i class='fas fa-feather-alt'></i> By ".htmlspecialchars($book['author'])."</p>
                    <div style='display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 15px;'>
                        <span style='color: {$statusColor}; font-weight: bold;'><i class='fas {$statusIcon}'></i> {$book['status']}</span>
                        $btn
                    </div>
                </div>";
            }
        } else {
            echo "<p style='color: var(--muted); font-size: 1.1rem; grid-column: 1 / -1;'>No books found. Please try different keywords.</p>";
        }
        ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>