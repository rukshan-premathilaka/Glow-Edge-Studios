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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel · Dashboard</title>
  <link rel="stylesheet" href="/public/css/admin/style.css"/>
  <?php echo $csrf->getScriptTag(); ?>
</head>
<body>
  <aside class="sidebar">
    <div class="brand">
      <img src="/public/assets/ui/LOGO.png" alt="Logo"/>
      <h1>Glow Edge</h1>
    </div>
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
      <div class="welcome">Admin Panel · Dashboard</div>
      <div class="profile-wrap">
        <span class="profile-name">Welcome, <?php echo $user->getUserName() ?></span>
        <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
          <img src="<?php echo $user->getProfilePic(); ?>"
               alt="Profile pic"
               style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div class="dropdown">
          <a href="/user/profile_settings">My Profile</a>
          <a href="/admin/dashboard">Dashboard</a>
          <a href="/admin/portfolio">Portfolio</a>
          <a href="/admin/services">Services</a>
          <a href="/admin/bookings">Bookings</a>
        </div>
      </div>
    </div>

    <div class="container grid cols-4">
      <div class="card kpi"><span class="title">Total Bookings</span><span class="value"><?php echo $booking->getCountTotal() ?></span></div>
      <div class="card kpi"><span class="title">Pending Bookings</span><span class="value"><?php echo $booking->getCountPending() ?></span></div>
      <div class="card kpi"><span class="title">Portfolio Items</span><span class="value"><?php echo $portfolio->getCount() ?></span></div>
      <div class="card kpi"><span class="title">Services Offered</span><span class="value"><?php echo $service->getCount() ?></span></div>
    </div>

    <div class="container">
      <div class="card">
        <div class="section-title">Recent Bookings</div>
        <table class="table">
          <thead><tr><th>Client</th><th>Service</th><th>Date</th><th>Status</th><th></th></tr></thead>
          <tbody>
            <tr><td>Alex F.</td><td>Wedding Photography</td><td>2025-11-05</td>
              <td><span class="badge warn">Pending</span></td>
              <td class="toolbar"><a class="btn ghost" href="booking-details.html">Details</a></td></tr>
            <tr><td>Nora L.</td><td>Service 2</td><td>2025-10-15</td>
              <td><span class="badge ok">Confirmed</span></td>
              <td class="toolbar"><a class="btn ghost" href="booking-details.html">Details</a></td></tr>
            <tr><td>Sam K.</td><td>Service 3</td><td>2025-10-09</td>
              <td><span class="badge bad">Cancelled</span></td>
              <td class="toolbar"><a class="btn ghost" href="booking-details.html">Details</a></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <script src="/public/js/admin/script.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>
