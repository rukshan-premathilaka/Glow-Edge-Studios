<?php

use controller\Service;
use controller\Booking;
use controller\Portfolio;

$booking = new Booking();
$portfolio = new Portfolio();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Glow Edge - Graphic Design & Photography</title>
  <link rel="stylesheet" href="/public/css/style.css" />
</head>
<body>

  <!-- Intro Video Overlay -->
  <div id="intro-video-container">
    <video id="intro-video" autoplay muted playsinline>
      <source src="/public/assets/ui/GlowEdge.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
  </div>

  <!-- Page Content Wrapper (hidden initially) -->
  <div id="page-content" class="hidden">

    <!-- Header -->
    <header>
      <div class="logo">
        <img src="/public/assets/ui/LOGO.png" alt="Glow Edge Logo" />
        <h1>Glow Edge</h1>
      </div>
      <nav>
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="/user/login">Sign In</a></li>
          <li><a href="/user/signup" >Sign Up</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-text">
        <h2>We Create Stunning Designs & Capture Timeless Moments</h2>
        <p>Your one-stop solution for professional graphic design & photography.</p>
        <!-- Removed View Portfolio button -->
      </div>
    </section>

    <!-- Services Section -->
    <section class="services">
      <h2>Our Services</h2>
      <div class="services-gallery">
        <div class="service-item">
          <img src="/public/assets/ui/otherphoto.jpg" alt="Graphic Designing" />
          <h3>Graphic Designing</h3>
          <p>Creative and professional graphic design solutions tailored to your brand.</p>
        </div>
        <div class="service-item">
          <img src="/public/assets/ui/photography.jpeg" alt="Photography" />
          <h3>Photography</h3>
          <p>Capturing timeless moments with expert photography services.</p>
        </div>
      </div>
    </section>

    <!-- About Us Section (static) -->
    <section class="about-us">
      <h2>About Us</h2>
      <p>
Glow Edge is your trusted partner in creative graphic design and professional photography. We craft stunning visuals and capture unforgettable moments tailored to your needs. Our team is passionate about delivering excellence and helping your brand shine through exceptional creativity.
      </p>
    </section>

    <!-- Contact Us Section -->
    <section class="contact-us">
      <h2>Contact Us</h2>
      <p><strong>Phone:</strong> 066 222 2222</p>
      <p><strong>Email:</strong> <a href="mailto:glowedge@gmail.com">glowedge@gmail.com</a></p>
    </section>

    <!-- Footer -->
    <footer>
      <p>© 2025 Glow Edge | Designed by Glow Edge Team</p>
    </footer>

  </div>

<script src="/public/js/script.js"></script>
<script src="/public/js/"></script>
</body>
</html>

