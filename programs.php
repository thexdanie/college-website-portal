<?php 
$pageTitle = "Programs | BCC Inc.";
include 'includes/header.php'; 
?>

<section style="background: var(--primary); color: white; padding: 50px 0; text-align: center;">
    <div class="container">
        <h1 class="heading-font" style="margin: 0; font-size: 2.5rem;">Academic Programs</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; margin-top: 10px;">Choose your path to a successful future at BCC Inc.</p>
    </div>
</section>

<section class="container" style="padding: 50px 20px; min-height: 60vh;">
    
    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="color: var(--primary); font-size: 2rem;">Our Degree Offerings</h2>
        <p style="color: #666; max-width: 600px; margin: 0 auto;">High-quality, accredited programs designed to nurture competent professionals and morally upright citizens.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1000px; margin: 0 auto;">
        
        <div class="card" style="display: flex; flex-direction: column; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--primary);">
            <i class="fas fa-briefcase" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px;"></i>
            <h3 style="margin-top: 0; color: #333;">BS Business Administration (BSBA)</h3>
            <p style="color: #666; font-size: 0.95rem;">Preparing students for the corporate world and entrepreneurship with specialized majors.</p>
            <ul style="color: #555; font-size: 0.9rem; padding-left: 20px; margin-bottom: 20px;">
                <li>Major in Financial Management (FM)</li>
                <li>Major in Human Resource Management (HR)</li>
                <li>Corporate Leadership</li>
            </ul>
            <a href="inquiry.php?course=BSBA" class="btn" style="margin-top: auto; display: block; text-align: center; background: var(--primary); color: white; padding: 10px; text-decoration: none; border-radius: 4px; font-weight: bold;">Inquire Now</a>
        </div>

        <div class="card" style="display: flex; flex-direction: column; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--primary);">
            <i class="fas fa-calculator" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px;"></i>
            <h3 style="margin-top: 0; color: #333;">BS Accountancy (BSA)</h3>
            <p style="color: #666; font-size: 0.95rem;">Rigorous training for aspiring Certified Public Accountants (CPAs) and financial experts.</p>
            <ul style="color: #555; font-size: 0.9rem; padding-left: 20px; margin-bottom: 20px;">
                <li>Financial Accounting & Reporting</li>
                <li>Auditing and Assurance</li>
                <li>Taxation and Business Law</li>
            </ul>
            <a href="inquiry.php?course=BSA" class="btn" style="margin-top: auto; display: block; text-align: center; background: var(--primary); color: white; padding: 10px; text-decoration: none; border-radius: 4px; font-weight: bold;">Inquire Now</a>
        </div>

        <div class="card" style="display: flex; flex-direction: column; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--primary);">
            <i class="fas fa-laptop-code" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px;"></i>
            <h3 style="margin-top: 0; color: #333;">BS Information Technology (BSIT)</h3>
            <p style="color: #666; font-size: 0.95rem;">Equips students with the technical computing skills needed for the fast-paced tech industry.</p>
            <ul style="color: #555; font-size: 0.9rem; padding-left: 20px; margin-bottom: 20px;">
                <li>Software & Web Development</li>
                <li>Advanced Database Systems</li>
                <li>Networking & Security</li>
            </ul>
            <a href="inquiry.php?course=BSIT" class="btn" style="margin-top: auto; display: block; text-align: center; background: var(--primary); color: white; padding: 10px; text-decoration: none; border-radius: 4px; font-weight: bold;">Inquire Now</a>
        </div>

        <div class="card" style="display: flex; flex-direction: column; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--primary);">
            <i class="fas fa-chalkboard-teacher" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px;"></i>
            <h3 style="margin-top: 0; color: #333;">Teacher Education (EDUC)</h3>
            <p style="color: #666; font-size: 0.95rem;">Producing highly competent and licensed educators for both elementary and high school levels.</p>
            <ul style="color: #555; font-size: 0.9rem; padding-left: 20px; margin-bottom: 20px;">
                <li>Bachelor of Elementary Education (BEEd)</li>
                <li>Bachelor of Secondary Education (BSEd)</li>
                <li>Modern Teaching Methodologies</li>
            </ul>
            <a href="inquiry.php?course=BSED" class="btn" style="margin-top: auto; display: block; text-align: center; background: var(--primary); color: white; padding: 10px; text-decoration: none; border-radius: 4px; font-weight: bold;">Inquire Now</a>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>