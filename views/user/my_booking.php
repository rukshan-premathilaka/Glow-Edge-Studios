<?php

use middleware\CsrfToken;
$csrf = new CsrfToken();

$user = new \controller\User();
$data = $user->getUserData();

$Bookings = (new \controller\Booking())->getAllByUser();

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

<!-- Booking Details Card (hidden by default) -->
<div id="bookingDetailsCard" class="details-overlay">
    <div class="details-card">
        <button class="close-btn" onclick="closeBookingDetails()">&times;</button>
        <h2 id="detailsTitle">Service Title</h2>

        <div class="details-row">
            <span class="label">Status:</span>
            <span class="value" id="detailsStatus"></span>
        </div>

        <div class="details-row">
            <span class="label">Requested At:</span>
            <span class="value" id="detailsCreated"></span>
        </div>

        <div class="details-row">
            <span class="label">Updated At:</span>
            <span class="value" id="detailsUpdated"></span>
        </div>

        <div class="details-section">
            <h4>Your Message</h4>
            <p id="detailsClientMsg"></p>
        </div>

        <div class="details-section">
            <h4>Admin Reply</h4>
            <p id="detailsAdminMsg"></p>
        </div>
    </div>
</div>



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


      <div style="overflow-y: scroll; height: calc(100vh - 100px);">
      <?php

      if (empty($Bookings)) {
          echo '<p>No bookings found.</p>';
      }

      foreach ($Bookings as $booking) {

          echo '<div class="booking-card">';
          echo '<h3>' . $booking['title'] . '</h3>';
          if ($booking['status'] === 'pending') { echo '<p>Requested at: ' . $booking['created_at'] . '</p>'; }
          if ($booking['status'] === 'confirmed') { echo '<p>Booked for: ' . $booking['created_at'] . '</p>'; }
          if ($booking['status'] === 'completed') { echo '<p>Completed at: ' . $booking['created_at'] . '</p>'; }
          if ($booking['status'] === 'cancelled') { echo '<p>Cancelled at: ' . $booking['created_at'] . '</p>'; }
          echo '<span class="status ' . $booking['status'] . '">' . $booking['status'] . '</span>';
          echo '<button class="view-details" onclick="viewBookingDetails( '. $booking['booking_id'] .')">View Details</button>';
          echo '</div>';
      }
      ?>
      </div>

  </div>


  <script type="module" src="/public/js/user/logout.js"></script>
  <script src="/public/js/user/booking.js"></script>
</body>
</html>
