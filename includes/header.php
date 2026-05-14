<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binalbagan Catholic College Inc.</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- 2. Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nav.css">
</head>

    <style>
        /* --- KEEPING ALL YOUR APPLE STYLING --- */
        body, p, span, a, div, h1, h2, h3, h4, label, li {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
            -webkit-font-smoothing: antialiased;
        }

        body { background-color: #fbfbfd !important; }

        h1, h2, h3, h4, .heading-font {
            font-weight: 700 !important;
            letter-spacing: -0.02em !important;
        }

        .card, div[style*="box-shadow"], div[style*="border-radius: 8px"], div[style*="border-radius:8px"] {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 24px !important; 
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        }

        .card:hover, div[style*="box-shadow"]:hover:not(form div), div[style*="border-radius: 8px"]:hover:not(form div) {
            transform: translateY(-5px) !important;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08) !important;
        }

        .btn, button, a[style*="background: #0047AB"], a[style*="background: var(--primary)"], button[type="submit"] {
            background-color: #0071e3 !important; 
            color: #ffffff !important;
            border-radius: 980px !important; 
            font-weight: 500 !important;
            border: none !important;
            text-transform: none !important;
            letter-spacing: 0 !important;
            box-shadow: none !important;
            transition: all 0.2s ease !important;
        }

        .btn:hover, button:hover, a[style*="background: #0047AB"]:hover, a[style*="background: var(--primary)"]:hover, button[type="submit"]:hover {
            background-color: #0077ed !important;
            transform: scale(1.02) !important;
        }

        input[type="text"], input[type="email"], select, textarea {
            border-radius: 12px !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            background-color: rgba(255, 255, 255, 0.8) !important;
            padding: 14px !important;
            transition: all 0.2s ease !important;
        }

        input[type="text"]:focus, input[type="email"]:focus, select:focus, textarea:focus {
            outline: none !important;
            border-color: #0071e3 !important;
            box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.15) !important;
            background-color: #ffffff !important;
        }

        /* --- NEW NAV PILL STYLING --- */
        .nav-links li a {
            padding: 8px 18px !important;
            border-radius: 980px !important; /* The Oblong Shape */
            transition: all 0.3s ease !important;
            color: rgba(255, 255, 255, 0.85); /* Slightly faded white for inactive */
            text-decoration: none;
            font-weight: 500;
        }

        .nav-links li a:hover {
            background: rgba(255, 255, 255, 0.15) !important; /* Subtle hover effect */
            color: #ffffff;
        }

        /* The Active Highlight State */
        .active-nav {
            background: #ffffff !important;
            color: #0071e3 !important; /* BCC/Apple Blue text */
            font-weight: 700 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }

        /* --- UPDATED PRINT FIX --- */
        @media print {
            .navbar, #theme-toggle, .hamburger, .btn, footer, .fas, 
            [style*="flex-direction: column"],
            [style*="text-align: center; margin-bottom: 50px;"], 
            .welcome-area { 
                display: none !important; 
            }

            body { background: white !important; margin: 0; padding: 0; }
            
            .print-only-header {
                display: flex !important;
                flex-direction: row !important; 
                align-items: center;
                justify-content: center;
                gap: 30px;
                border-bottom: 2px solid #000;
                padding-bottom: 20px;
                margin-bottom: 30px;
            }

            .print-only-header img { 
                height: 100px !important; 
                width: auto !important; 
                object-fit: contain !important;
            }

            .card {
                background: transparent !important;
                box-shadow: none !important;
                border: none !important;
                backdrop-filter: none !important;
                width: 100% !important;
                padding: 0 !important;
            }

            table { width: 100% !important; border-collapse: collapse; }
            th, td { border: 1px solid #ccc !important; padding: 10px !important; color: black !important; }
            
            span[style*="background"] {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border: 1px solid #ccc !important;
                color: black !important;
                background-color: #eee !important;
            }
        }

        .print-only-header { display: none; }
    </style>
</head>
<body>

<div class="print-only-header">
    <img src="assets/images/logo.png" alt="BCC Logo">
    <div style="text-align: center;">
        <h2 style="margin: 0; font-size: 18pt; color: black; font-weight: 800;">Binalbagan Catholic College Inc.</h2>
        <p style="margin: 2px 0; color: black; font-size: 10pt;">Enriching Lives, Building Futures Since 1950</p>
        <p style="margin: 2px 0; color: black; font-size: 10pt;">Binalbagan, Negros Occidental, Philippines</p>
        <h3 style="margin-top: 10px; text-decoration: underline; text-transform: uppercase; color: black; font-size: 14pt;">Official Grade Slip</h3>
    </div>
</div>

<nav class="navbar">
    <div class="container nav-flex">
        <a href="index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; color: white;">
            <img src="assets/images/logo.png" alt="BCC Logo" style="height: 50px; width: auto; object-fit: contain;">
            <span style="font-weight: bold; font-size: 1.5rem;">BCC INC.</span>
        </a>
        <ul class="nav-links">
            <!-- Added the "nav-item" class so our script can find these specific links -->
            <li><a href="index.php#home" class="nav-item active-nav">Home</a></li>
            <li><a href="index.php#about" class="nav-item">About</a></li>
            <li><a href="index.php#programs" class="nav-item">Programs</a></li>
            <li><a href="index.php#news" class="nav-item">News</a></li>
            <li><a href="index.php#contact" class="nav-item">Contact</a></li>
            <li><button id="theme-toggle"><i class="fas fa-moon"></i></button></li>
        </ul>
        <div class="hamburger"><i class="fas fa-bars"></i></div>
    </div>
</nav>

<!-- NAV PILL JAVASCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navItems = document.querySelectorAll('.nav-item');

        // Check if there's already a hash in the URL on load (e.g., user refreshes on index.php#about)
        const currentHash = window.location.hash || '#home';
        
        navItems.forEach(link => {
            // Set initial active state based on URL
            if (link.getAttribute('href').includes(currentHash)) {
                navItems.forEach(nav => nav.classList.remove('active-nav'));
                link.classList.add('active-nav');
            }

            // Click event to move the pill smoothly
            link.addEventListener('click', function() {
                // Remove the white pill from all links
                navItems.forEach(nav => nav.classList.remove('active-nav'));
                // Add the white pill to the clicked link
                this.classList.add('active-nav');
            });
        });
    });
</script>
