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
  <title>Admin Panel · Manage Portfolio</title>
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
      <div class="welcome">Admin Panel · Manage Portfolio</div>
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
        <div class="muted">Filters:</div>
        <button class="btn ghost">All</button>
        <button class="btn ghost">Photography</button>
        <button class="btn ghost">Graphic Design</button>
        <button class="btn ghost">Others</button>
        <a href="/admin/add_portfolio" class="btn primary">+ Add New Item</a>
      </div>
      <div class="spacer"></div>

      <div class="grid cols-3">
        <!-- Sample item cards -->
        <div class="card">
          <div class="section-title">Sample Work 01</div>
          <div class="muted" style="margin-bottom:10px">Category: Photography</div>
          <div class="toolbar">
            <a href="add-portfolio.php" class="btn">Edit</a>
            <button class="btn danger" data-action="delete" data-name="portfolio item">Delete</button>
          </div>
        </div>
        <div class="card">
          <div class="section-title">Sample Work 02</div>
          <div class="muted" style="margin-bottom:10px">Category: Graphic Design</div>
          <div class="toolbar">
            <a href="add-portfolio.php" class="btn">Edit</a>
            <button class="btn danger" data-action="delete" data-name="portfolio item">Delete</button>
          </div>
        </div>
        <div class="card">
          <div class="section-title">Sample Work 03</div>
          <div class="muted" style="margin-bottom:10px">Category: Others</div>
          <div class="toolbar">
            <a href="add-portfolio.php" class="btn">Edit</a>
            <button class="btn danger" data-action="delete" data-name="portfolio item">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="/public/js/admin/script.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>
