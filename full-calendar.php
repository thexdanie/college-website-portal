<?php
require_once 'config/db.php';
include 'includes/header.php';

// 1. Get current month and year from the URL (or default to today)
$m = isset($_GET['m']) ? (int)$_GET['m'] : date('m');
$y = isset($_GET['y']) ? (int)$_GET['y'] : date('Y');

// 2. Calculate Next and Previous months for the buttons
$prevM = $m - 1; $prevY = $y;
if ($prevM == 0) { $prevM = 12; $prevY--; }

$nextM = $m + 1; $nextY = $y;
if ($nextM == 13) { $nextM = 1; $nextY++; }

// 3. Get the first and last day of the selected month
$firstDayDate = "$y-" . str_pad($m, 2, "0", STR_PAD_LEFT) . "-01";
$daysInMonth = date('t', strtotime($firstDayDate));
$firstDayOfWeek = date('w', strtotime($firstDayDate)); // 0 = Sunday, 6 = Saturday
$monthName = date('F Y', strtotime($firstDayDate));

// 4. Fetch events ONLY for this specific month
$stmt = $pdo->prepare("SELECT * FROM academic_calendar WHERE MONTH(event_date) = ? AND YEAR(event_date) = ? ORDER BY event_date ASC");
$stmt->execute([$m, $y]);
$events = $stmt->fetchAll();

// 5. Organize events by day so they are easy to place in the grid
$calendarData = [];
foreach ($events as $ev) {
    $day = (int)date('d', strtotime($ev['event_date']));
    $calendarData[$day][] = $ev;
}
?>

<section style="background: var(--primary); color: white; padding: 50px 0; text-align: center;">
    <div class="container">
        <h1 class="heading-font" style="margin: 0; font-size: 2.5rem;">Academic Calendar</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; margin-top: 10px;">Plan your semester accordingly.</p>
    </div>
</section>

<section class="container" style="padding: 50px 20px; min-height: 60vh;">
    
    <div class="card" style="max-width: 900px; margin: 0 auto; padding: 30px; border-top: 5px solid var(--primary); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="?m=<?php echo $prevM; ?>&y=<?php echo $prevY; ?>" class="btn" style="background: var(--light); color: var(--primary); text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold;">
                &laquo; Prev
            </a>
            
            <h2 style="margin: 0; color: var(--primary); font-size: 1.8rem;">
                <i class="far fa-calendar-alt"></i> <?php echo $monthName; ?>
            </h2>
            
            <a href="?m=<?php echo $nextM; ?>&y=<?php echo $nextY; ?>" class="btn" style="background: var(--light); color: var(--primary); text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold;">
                Next &raquo;
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; background: var(--border); border: 1px solid var(--border);">
            
            <?php 
            $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach($days as $dayLabel) {
                echo "<div style='background: var(--primary); color: white; text-align: center; padding: 10px; font-weight: bold;'>{$dayLabel}</div>";
            }
            ?>

            <?php for ($i = 0; $i < $firstDayOfWeek; $i++): ?>
                <div style="background: #f9f9f9; min-height: 90px; padding: 10px;"></div>
            <?php endfor; ?>

            <?php for ($day = 1; $day <= $daysInMonth; $day++): 
                $isToday = ($day == date('j') && $m == date('n') && $y == date('Y'));
                $bgClass = $isToday ? "background: #e6f2ff; border: 2px solid var(--primary);" : "background: white;";
            ?>
                <div style="<?php echo $bgClass; ?> min-height: 90px; padding: 10px; display: flex; flex-direction: column;">
                    
                    <span style="font-weight: bold; font-size: 1.2rem; color: <?php echo $isToday ? 'var(--primary)' : 'var(--text)'; ?>; margin-bottom: 5px;">
                        <?php echo $day; ?>
                    </span>
                    
                    <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
                        <?php if (isset($calendarData[$day])): ?>
                            <?php foreach ($calendarData[$day] as $ev): 
                                // Color logic based on category
                                $evtColor = "#007bff"; // Blue default
                                if ($ev['category'] == 'Holiday') $evtColor = "#28a745"; // Green
                                if ($ev['category'] == 'Exam') $evtColor = "#dc3545"; // Red
                                if ($ev['category'] == 'Event') $evtColor = "#fd7e14"; // Orange
                            ?>
                                <div style="background: <?php echo $evtColor; ?>; color: white; font-size: 0.75rem; padding: 4px 6px; border-radius: 3px; line-height: 1.2; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; cursor: pointer;" 
     title="<?php echo htmlspecialchars($ev['event_title']); ?><?php echo !empty($ev['event_description']) ? '&#10;Info: ' . htmlspecialchars($ev['event_description']) : ''; ?>">
    
    <?php echo htmlspecialchars($ev['event_title']); ?>

</div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
            
            <?php 
            $totalCells = $firstDayOfWeek + $daysInMonth;
            $remainingCells = 7 - ($totalCells % 7);
            if ($remainingCells < 7) {
                for ($i = 0; $i < $remainingCells; $i++) {
                    // CHANGED MIN-HEIGHT TO 90px
                    echo "<div style='background: #f9f9f9; min-height: 90px; padding: 10px;'></div>";
                }
            }
            ?>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>