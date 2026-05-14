<?php 
$pageTitle = "Home | BCC Inc.";
require_once 'config/db.php';
include 'includes/header.php'; 

// --- 1. PHP LOGIC FOR STATS & UPDATES ---
$studentStmt = $pdo->query("SELECT COUNT(*) FROM students"); 
$total_students = $studentStmt->fetchColumn();
$programStmt = $pdo->query("SELECT COUNT(*) FROM programs");
$total_programs = $programStmt->fetchColumn();
$years_excellence = date("Y") - 1950;

// FIXED: Changed posted_at to created_at
$newsStmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 2");
$updates = $newsStmt->fetchAll();

// --- 2. PHP LOGIC FOR CONTACT FORM ---
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_inquiry'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $program = $_POST['course'];
    $student_message = $_POST['message'];
    try {
        $stmt = $pdo->prepare("INSERT INTO inquiries (full_name, email, program_interest, message, status) VALUES (?, ?, ?, ?, 'unread')");
        $stmt->execute([$name, $email, $program, $student_message]);
        $message = "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; text-align: center;'><i class='fas fa-check-circle'></i> Thank you! Your inquiry has been sent.</div>";
    } catch(PDOException $e) {
        $message = "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; text-align: center;'><i class='fas fa-exclamation-triangle'></i> Error: " . $e->getMessage() . "</div>";
    }
}
?>

<section id="home" class="hero" style="padding: 120px 0 160px 0; background: linear-gradient(rgba(0, 71, 171, 0.8), rgba(0, 71, 171, 0.9)), url('assets/images/my-campus-photo.jpg') center bottom/cover;">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: clamp(3rem, 5vw, 4.5rem); margin-bottom: 10px; color: white; text-shadow: 0px 4px 10px rgba(0, 0, 0, 0.7); font-weight: 800; letter-spacing: -0.03em;"> Binalbagan Catholic College Inc. </h1>
        <p style="font-size: 1.3rem; font-weight: 600; letter-spacing: 1px; color: #E8E8E8;">STEWARDSHIP. JUSTICE. SOLIDARITY</p>
        <div class="hero-btns" style="margin-top: 40px; display: flex; gap: 15px; justify-content: center;">
            <a href="#programs" class="btn">Explore Programs</a>
            <a href="apply.php" class="btn" style="background: rgba(255,255,255,0.1) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.5) !important;">Admissions & Enrollment</a>
        </div>
    </div>
</section>

<!-- PORTAL CARDS (Upgraded with Bootstrap Grid) -->
<div class="container" style="margin-top: -60px; position: relative; z-index: 10;">
    <div class="row g-4"> 
        
        <!-- Card 1: Student -->
        <div class="col-md-4">
            <a href="student-login.php" class="card h-100" style="text-align: center; text-decoration: none; padding: 30px; border-top: 4px solid #0047AB;">
                <i class="fas fa-user-graduate" style="font-size: 2.5rem; color: #0047AB; margin-bottom: 15px;"></i>
                <h3 style="color: #2C3E50; font-size: 1.2rem; margin: 0; font-weight: 700;">Student Portal</h3>
                <p style="color: #5D6D7E; font-size: 0.9rem; margin-top: 5px;">Grades & Schedules</p>
            </a>
        </div>

        <!-- Card 2: Library -->
        <div class="col-md-4">
            <a href="library.php" class="card h-100" style="text-align: center; text-decoration: none; padding: 30px; border-top: 4px solid #0047AB;">
                <i class="fas fa-book-reader" style="font-size: 2.5rem; color: #0047AB; margin-bottom: 15px;"></i>
                <h3 style="color: #2C3E50; font-size: 1.2rem; margin: 0; font-weight: 700;">Online Library</h3>
                <p style="color: #5D6D7E; font-size: 0.9rem; margin-top: 5px;">Journals & Resources</p>
            </a>
        </div>

        <!-- Card 3: Faculty -->
        <div class="col-md-4">
            <a href="faculty-login.php" class="card h-100" style="text-align: center; text-decoration: none; padding: 30px; border-top: 4px solid #0047AB;">
                <i class="fas fa-chalkboard-teacher" style="font-size: 2.5rem; color: #0047AB; margin-bottom: 15px;"></i>
                <h3 style="color: #2C3E50; font-size: 1.2rem; margin: 0; font-weight: 700;">Faculty LMS</h3>
                <p style="color: #5D6D7E; font-size: 0.9rem; margin-top: 5px;">Learning Management</p>
            </a>
        </div>

    </div>
</div>

<section id="about" style="padding: 100px 20px; background: #fbfbfd;">
    <div style="text-align: center; margin-bottom: 60px;">
        <h2 style="font-size: 3rem; color: #1d1d1f; letter-spacing: -0.02em;">Our History & Identity</h2>
        <p style="font-size: 1.2rem; color: #86868b;">A legacy of faith and academic excellence since 1950.</p>
    </div>

    <div class="container card" style="padding: 60px 40px; text-align: center; max-width: 1000px; margin: 0 auto 60px auto; border-top: 4px solid #0071e3;">
        <h2 style="font-size: 1.2rem; color: #0071e3; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.15em;">Our Mission</h2>
        <p style="font-size: clamp(1.1rem, 2vw, 1.4rem); line-height: 1.6; color: #1d1d1f; font-weight: 500; margin-bottom: 40px; font-style: italic;">
            "A Catholic educational institution run by the Presentation Sisters of the Blessed Virgin Mary... providing quality, holistic, and transformative education to 21st-century learners delivered through relevant instruction, research, and community outreach."
        </p>
        <h2 style="font-size: 1.2rem; color: #0071e3; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.15em;">Our Vision</h2>
        <p style="font-size: clamp(1.1rem, 2vw, 1.4rem); line-height: 1.6; color: #1d1d1f; font-weight: 500; margin: 0; font-style: italic;">
            "Christ-centered advocates of excellence, social justice, stewardship, and social transformation in a rapidly changing world."
        </p>
    </div>

    <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto;">
        <div class="card" style="padding: 50px 30px; text-align: center;">
            <i class="fas fa-leaf" style="font-size: 3.5rem; color: #34c759; margin-bottom: 25px;"></i>
            <h3 style="font-size: 1.8rem; margin-bottom: 15px; color: #1d1d1f;">Stewardship</h3>
            <p style="color: #86868b; line-height: 1.6; margin: 0;">Responsible caretakers of creation and our common home.</p>
        </div>
        <div class="card" style="padding: 50px 30px; text-align: center;">
            <i class="fas fa-balance-scale" style="font-size: 3.5rem; color: #0071e3; margin-bottom: 25px;"></i>
            <h3 style="font-size: 1.8rem; margin-bottom: 15px; color: #1d1d1f;">Justice</h3>
            <p style="color: #86868b; line-height: 1.6; margin: 0;">Upholding what is right and equitable for the marginalized.</p>
        </div>
        <div class="card" style="padding: 50px 30px; text-align: center;">
            <i class="fas fa-hands-helping" style="font-size: 3.5rem; color: #ff9500; margin-bottom: 25px;"></i>
            <h3 style="font-size: 1.8rem; margin-bottom: 15px; color: #1d1d1f;">Solidarity</h3>
            <p style="color: #86868b; line-height: 1.6; margin: 0;">Working in synergy and unity with our community.</p>
        </div>
    </div>
</section>

<section id="programs" style="padding: 100px 20px; background: #ffffff; border-top: 1px solid rgba(0,0,0,0.05);">
    <div class="container" style="text-align: center; margin-bottom: 60px;">
        <h2 style="font-size: 3rem; color: #1d1d1f; letter-spacing: -0.02em;">Our Degree Offerings</h2>
        <p style="font-size: 1.2rem; color: #86868b;">Accredited programs designed to nurture competent professionals.</p>
    </div>

    <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; text-align: left; max-width: 1200px; margin: 0 auto;">
        <?php 
        $program_list = [
            ['title' => 'BS Business Administration', 'icon' => 'fa-briefcase', 'desc' => 'Preparing students for the corporate world and entrepreneurship.'],
            ['title' => 'BS Accountancy', 'icon' => 'fa-calculator', 'desc' => 'Rigorous training for aspiring Certified Public Accountants.'],
            ['title' => 'BS Information Technology', 'icon' => 'fa-laptop-code', 'desc' => 'Equips students with the technical skills for the tech industry.'],
            ['title' => 'Teacher Education', 'icon' => 'fa-chalkboard-teacher', 'desc' => 'Producing highly competent educators for elementary and high school.']
        ];
        foreach($program_list as $prog): ?>
        <div class="card" style="padding: 30px; display: flex; flex-direction: column; height: 100%; border-top: 4px solid #0071e3;">
            <i class="fas <?php echo $prog['icon']; ?>" style="font-size: 2.5rem; color: #0071e3; margin-bottom: 20px;"></i>
            <h3 style="font-size: 1.4rem; margin-top: 0; color: #1d1d1f;"><?php echo $prog['title']; ?></h3>
            <p style="color: #86868b; line-height: 1.6; margin-bottom: 20px;"><?php echo $prog['desc']; ?></p>
            <a href="apply.php" class="btn" style="margin-top: auto; text-align: center; padding: 12px; display: block; text-decoration: none;">Inquire Now</a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="news" style="padding: 100px 20px; background: #fbfbfd; border-top: 1px solid rgba(0,0,0,0.05);">
    <div class="container grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; max-width: 1200px; margin: 0 auto;">
        
        <div>
            <h2 style="color: #1d1d1f; margin-bottom: 30px; font-size: 2.2rem; letter-spacing: -0.02em;">Campus Updates</h2>
            <div style="display: grid; gap: 20px;">
                <?php
                // FIXED: Changed posted_at to created_at
                $stmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 2");
                if ($stmt->rowCount() > 0):
                    while ($row = $stmt->fetch()) {
                        // FIXED: Changed posted_at to created_at
                        $date = date("F j, Y", strtotime($row['created_at'])); ?>
                        <div class='card' style='padding: 30px; border-left: 4px solid #0071e3; text-align: left;'>
                            <small style='color: #86868b; display: block; margin-bottom: 10px;'><i class='far fa-calendar'></i> <?php echo $date; ?> &nbsp;•&nbsp; <strong><?php echo $row['category']; ?></strong></small>
                            <h3 style='margin-top: 0; margin-bottom: 15px; color: #1d1d1f; font-size: 1.5rem;'><?php echo $row['title']; ?></h3>
                            <p style='color: #86868b; margin-bottom: 0; line-height: 1.6;'><?php echo substr($row['content'], 0, 180); ?>...</p>
                        </div>
                    <?php } ?>
                <?php else: ?>
                    <p style="color: #86868b;">No recent updates found.</p>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <h2 style="color: #1d1d1f; margin-bottom: 30px; font-size: 2.2rem; letter-spacing: -0.02em;">Upcoming Events</h2>
            <div class="card" style="padding: 20px;">
                <?php
                $eventStmt = $pdo->query("SELECT * FROM academic_calendar WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 4");
                if ($eventStmt->rowCount() > 0) {
                    while ($ev = $eventStmt->fetch()) {
                        $evMonth = date("M", strtotime($ev['event_date']));
                        $evDay = date("d", strtotime($ev['event_date'])); ?>
                        <div style='display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid rgba(0,0,0,0.05);'>
                            <div style='text-align: center; padding-right: 15px; margin-right: 15px; border-right: 1px solid rgba(0,0,0,0.1); min-width: 55px;'>
                                <span style='display: block; color: #0071e3; font-weight: 700; font-size: 0.9rem; text-transform: uppercase;'><?php echo $evMonth; ?></span>
                                <span style='display: block; color: #1d1d1f; font-size: 1.8rem; font-weight: 700; line-height: 1;'><?php echo $evDay; ?></span>
                            </div>
                            <div style='flex: 1;'>
                                <h4 style='margin: 0 0 5px 0; color: #1d1d1f; font-size: 1.1rem;'><?php echo $ev['event_title']; ?></h4>
                                <span style='background: rgba(0,0,0,0.05); color: #86868b; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;'><?php echo strtoupper($ev['category']); ?></span>
                            </div>
                        </div>
                <?php } 
                } else {
                    echo "<p style='color: #86868b; text-align: center; padding: 20px;'>No upcoming events scheduled.</p>";
                } ?>
            </div>
        </div>

    </div>
</section>

<section id="contact" style="padding: 100px 20px; background: #ffffff; border-top: 1px solid rgba(0,0,0,0.05);">
    <div class="container" style="max-width: 600px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 3rem; color: #1d1d1f; letter-spacing: -0.02em;">Get in Touch</h2>
            <p style="font-size: 1.2rem; color: #86868b;">Have questions? Send an inquiry to our admissions team.</p>
        </div>

        <div class="card" style="padding: 40px;">
            <?php echo $message; ?>
            <form method="POST" action="#contact">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1d1d1f; font-size: 0.95rem;">Full Name</label>
                    <input type="text" name="name" required style="width: 100%; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1d1d1f; font-size: 0.95rem;">Email Address</label>
                    <input type="email" name="email" required style="width: 100%; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1d1d1f; font-size: 0.95rem;">Program of Interest</label>
                    <select name="course" required style="width: 100%; box-sizing: border-box;">
                        <option value="General Contact">General Question</option>
                        <option value="BSBA">BS Business Administration (BSBA)</option>
                        <option value="BSA">BS Accountancy (BSA)</option>
                        <option value="BSIT">BS Information Technology (BSIT)</option>
                        <option value="BSED">Teacher Education (EDUC)</option>
                    </select>
                </div>
                <div style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1d1d1f; font-size: 0.95rem;">Message</label>
                    <textarea name="message" required rows="4" style="width: 100%; box-sizing: border-box; resize: vertical;"></textarea>
                </div>
                <button type="submit" name="submit_inquiry" class="btn" style="width: 100%; padding: 16px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>