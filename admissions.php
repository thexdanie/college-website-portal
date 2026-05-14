<?php 
require_once 'config/db.php';
include 'includes/header.php'; 
?>

<section class="container" style="padding: 60px 0;">
    <h1 class="heading-font" style="text-align: center; margin-bottom: 40px;">Admissions</h1>
    
    <div class="grid">
        <div class="card">
            <h3 style="color: var(--primary);">1. Application Process</h3>
            <ol style="padding-left: 20px; margin-top: 15px;">
                <li>Fill out the online inquiry form.</li>
                <li>Submit required documents to the registrar.</li>
                <li>Take the college entrance examination.</li>
                <li>Attend the applicant interview.</li>
                <li>Pay the initial enrollment fee.</li>
            </ol>
        </div>

        <div class="card">
            <h3 style="color: var(--primary);">2. Requirements</h3>
            <ul style="padding-left: 20px; margin-top: 15px; list-style-type: square;">
                <li>Original High School Report Card (Form 138)</li>
                <li>Certificate of Good Moral Character</li>
                <li>PSA Birth Certificate (Photocopy)</li>
                <li>2 pcs 2x2 ID Pictures (White background)</li>
                <li>Accomplished Application Form</li>
            </ul>
        </div>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <h3 class="heading-font">Ready to start your journey?</h3>
        <p style="margin-bottom: 20px;">Reach out to our admissions office today.</p>
        <a href="contact.php" class="btn btn-primary">Apply Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>