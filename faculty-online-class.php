<?php 
session_start();
include 'includes/header.php'; 
?>

<section style="padding: 60px 20px; background: #fbfbfd; min-height: 90vh;">
    <div class="container" style="max-width: 700px; text-align: center;">
        <div class="card" style="padding: 50px;">
            <div style="background: rgba(0, 113, 227, 0.1); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fas fa-video" style="font-size: 2rem; color: #0071e3;"></i>
            </div>
            <h1 style="font-weight: 800; margin-bottom: 10px;">Virtual Classroom</h1>
            <p style="color: #86868b; margin-bottom: 40px;">Launch your online session and notify your students.</p>

            <div style="text-align: left; margin-bottom: 30px;">
                <label style="font-weight: 700; display: block; margin-bottom: 10px;">Meeting Link (Zoom / Google Meet)</label>
                <input type="text" placeholder="https://zoom.us/j/123456789" style="width: 100%; box-sizing: border-box; padding: 15px; border-radius: 12px; border: 1px solid #ddd; font-size: 1rem;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <button class="btn" style="padding: 15px;">Launch Meeting</button>
                <button class="btn" style="padding: 15px; background: #34c759 !important;">Send Invite to Class</button>
            </div>
        </div>
    </div>
</section>