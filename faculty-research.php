<?php 
session_start();
include 'includes/header.php'; 
?>

<section style="padding: 60px 20px; background: #fbfbfd; min-height: 90vh;">
    <div class="container">
        <h1 style="font-weight: 800; margin-bottom: 40px;"><i class="fas fa-microscope" style="color: #5856d6;"></i> Research Portal</h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div class="card" style="padding: 30px;">
                <h3 style="margin: 0 0 10px 0;">Research Guidelines 2026</h3>
                <p style="color: #86868b; font-size: 0.9rem; margin-bottom: 20px;">Official BCC formatting and submission rules.</p>
                <a href="#" class="btn" style="background: #5856d6 !important; text-decoration: none; padding: 10px 20px; display: inline-block;">Download PDF</a>
            </div>
            
            <div class="card" style="padding: 30px;">
                <h3 style="margin: 0 0 10px 0;">Institutional Journal</h3>
                <p style="color: #86868b; font-size: 0.9rem; margin-bottom: 20px;">Access previous faculty research publications.</p>
                <a href="#" class="btn" style="background: #5856d6 !important; text-decoration: none; padding: 10px 20px; display: inline-block;">Open Archive</a>
            </div>
        </div>
    </div>
</section>