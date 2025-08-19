<?php

$booking = new \controller\Booking();
$portfolio = new \controller\Portfolio();
$service = new \controller\Service();
$csrf = new \middleware\CsrfToken();
$user = new \controller\User();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel · Manage Services</title>
  <link rel="stylesheet" href="/public/css/admin/style.css"/>
  <?php echo $csrf->getScriptTag(); ?>
</head>
<body>
  <aside class="sidebar">
    <div class="brand"><img src="/public/assets/ui/LOGO.png" alt="Logo"/><h1>Glow Edge</h1></div>
    <nav class="nav">
      <a href="/admin/dashboard">Dashboard</a>
      <a href="/admin/portfolio">Portfolio</a>
      <a href="/admin/services">Services</a>
      <a href="/admin/bookings">Bookings</a>
      <a class="logout" id="logoutButton" >Logout</a>
    </nav>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="welcome">Admin Panel · Manage Services</div>
      <div class="profile-wrap"><span class="profile-name">Welcome, <?php echo $user->getUserName() ?></span>
        <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
          <img src="<?php echo $user->getProfilePic(); ?>"
               alt="Profile pic"
               style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div class="dropdown">
          <nav class="nav">
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/portfolio">Portfolio</a>
            <a href="/admin/services">Services</a>
            <a href="/admin/bookings">Bookings</a>
            <a class="logout" id="logoutButton" >Logout</a>
          </nav>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="toolbar">
        <a href="/admin/add_service" class="btn primary">+ Add New Service</a>
      </div>
      <div class="spacer"></div>

      <div class="grid cols-3">
        <div class="card">
          <div class="section-title">Wedding Photography</div>
          <div class="muted" style="margin:6px 0 12px">Full-day package, 2 photographers, album included.</div>
          <div class="toolbar">
            <a href="add-service.html" class="btn">Edit</a>
            <button class="btn danger" data-action="delete" data-name="service">Delete</button>
          </div>
        </div>
        <div class="card">
          <div class="section-title">Event Coverage</div>
          <div class="muted" style="margin:6px 0 12px">Hourly/event based custom plan.</div>
          <div class="toolbar">
            <a href="add-service.html" class="btn">Edit</a>
            <button class="btn danger" data-action="delete" data-name="service">Delete</button>
          </div>
        </div>
        <div class="card">
          <div class="section-title">Graphic Design</div>
          <div class="muted" style="margin:6px 0 12px">Branding, posters, business cards, and more.</div>
          <div class="toolbar">
            <a href="add-service.html" class="btn">Edit</a>
            <button class="btn danger" data-action="delete" data-name="service">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="/public/js/admin/script.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>
