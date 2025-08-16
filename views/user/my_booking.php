<?php

use middleware\CsrfToken;
$csrf = new CsrfToken();

$user = new \controller\User();
$data = $user->getUserData();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Bookings - Glow Edge</title>
  <link rel="stylesheet" href="/public/css/user/user-panel.css">
    <?php echo $csrf->getScriptTag(); ?>
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="/public/assets/ui/LOGO.png" alt="Glow Edge Logo">
    </div>
    <a href="/home" data-page="home">Back to Home</a>
    <a href="/user/my_booking" class="active" data-page="bookings">My Bookings</a>
    <a href="/user/profile_settings" data-page="profile">Profile Settings</a>
      <a style="cursor: pointer"  class="logout" id="logoutButton" >Logout</a>
  </div>

  <div class="main">
    <header>
      <h2>My Bookings</h2>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span class="welcome" id="welcomeUser">Welcome, <?php echo $data['name'] ?> </span>
            <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                <img src="<?php echo $user->getProfilePic(); ?>"
                     alt="Profile pic"
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </header>

    <div class="booking-card">
      <h3>Wedding Photography</h3>
      <p>Requested for: November 05, 2025</p>
      <span class="status completed">Completed</span>
      <button class="view-details">View Details</button>
    </div>

    <div class="booking-card">
      <h3>Wedding Photography</h3>
      <p>Booked for: March 15, 2025</p>
      <span class="status confirmed">Confirmed</span>
      <button class="view-details">View Details</button>
    </div>

    <div class="booking-card">
      <h3>Wedding Photography</h3>
      <p>Booked for: March 15, 2025</p>
      <span class="status pending">Pending</span>
      <button class="view-details">View Details</button>
    </div>

    <div class="booking-card">
      <h3>Wedding Photography</h3>
      <p>Booked for: March 15, 2025</p>
      <span class="status cancelled">Cancelled</span>
      <button class="view-details">View Details</button>
    </div>
  </div>

  <script src="/js/user-panel.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>
