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
  <title>Admin Panel · Manage Bookings</title>
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
      <a href="#" class="logout">Logout</a>
    </nav>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="welcome">Admin Panel · Manage Bookings</div>
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

    <div class="container card">
      <div class="toolbar" style="justify-content:space-between">
        <div><strong>All Bookings</strong></div>
        <div style="display:flex;gap:10px;align-items:center">
          <label class="muted">Filter:</label>
          <select id="statusFilter">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
      </div>
      <div class="spacer"></div>
        <div class="table-container" style="max-height: calc( 100vh - 165px); overflow-y: auto; overflow-x: hidden;">
      <table class="table">
        <thead>
          <tr><th>Client</th><th>Service</th><th>Booking Date</th><th>Status</th><th>Actions</th></tr>
        </thead>
          <tbody>
          <?php
          // Assuming $booking->getAllView() returns the array of bookings
          $bookings = $booking->getAllView();

          if ($bookings) {
              foreach ($bookings as $item):
                  $status = htmlspecialchars($item['status']);
                  $name = htmlspecialchars($item['name']);
                  $serviceTitle = htmlspecialchars($item['title']);
                  $bookingDate = date('Y-m-d', strtotime($item['created_at']));
                  $bookingId = htmlspecialchars($item['booking_id']);

                  // Determine badge class
                  $badgeClass = '';
                  switch ($status) {
                      case 'pending':
                          $badgeClass = 'warn';
                          break;
                      case 'confirmed':
                          $badgeClass = 'ok';
                          break;
                      case 'completed':
                          $badgeClass = 'info';
                          break;
                      case 'cancelled':
                          $badgeClass = 'bad';
                          break;
                      default:
                          $badgeClass = 'info';
                  }

                  // Determine action buttons
                  $buttons = '';
                  if ($status === 'pending') {
                      $buttons .= '<button class="btn" data-action="confirm" data-id="' . $bookingId . '">Confirm</button>';
                      $buttons .= '<button class="btn warn" data-action="cancel" data-id="' . $bookingId . '">Cancel</button>';
                  } elseif ($status === 'cancelled') {
                      $buttons .= '<button class="btn danger" data-action="delete" data-id="' . $bookingId . '">Delete</button>';
                  }
                  ?>
                  <tr data-status="<?php echo $status; ?>">
                      <td><?php echo $name; ?></td>
                      <td><?php echo $serviceTitle; ?></td>
                      <td><?php echo $bookingDate; ?></td>
                      <td><span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span></td>
                      <td class="toolbar">
                          <a class="btn ghost" href="/admin/booking-details?id=<?php echo $bookingId; ?>">Details</a>
                          <button class="btn ghost" data-action="details" data-name="booking" data-id="<?php echo $bookingId; ?>">Details</button>
                          <?php echo $buttons; ?>
                      </td>
                  </tr>
              <?php
              endforeach;
          } else {
              // Display a message if no bookings are found
              echo '<tr><td colspan="5" style="text-align: center;">No bookings found.</td></tr>';
          }
          ?>
          </tbody>
      </table>
            </div>
    </div>
  </main>

  <script src="/public/js/admin/script.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
  <script type="module" src="/public/js/admin/booking/booking.js"></script>

</body>
</html>
