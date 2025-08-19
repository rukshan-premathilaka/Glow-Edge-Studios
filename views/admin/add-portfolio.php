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
  <title>Admin Panel · Add/Edit Portfolio</title>
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
      <div class="welcome">Admin Panel · Add / Edit Portfolio</div>
      <div class="profile-wrap"><span class="profile-name">Welcome, <?php echo $user->getUserName() ?></span>
          <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
              <img src="<?php echo $user->getProfilePic(); ?>"
                   alt="Profile pic"
                   style="width: 100%; height: 100%; object-fit: cover;">
          </div>
        <div class="dropdown"><a href="#">My Profile</a><a href="portfolio.php">Back to Portfolio</a></div>
      </div>
    </div>

    <div class="container">
      <form class="card form">
        <div class="row">
          <div>
            <label>Title</label>
            <input type="text" placeholder="e.g., Wedding Shoot – Ella"/>
          </div>
          <div>
            <label>Category</label>
            <select>
              <option>Photography</option><option>Graphic Design</option><option>Others</option>
            </select>
          </div>
        </div>
        <div>
          <label>Description</label>
          <textarea placeholder="Short description..."></textarea>
        </div>
        <div>
          <label>Images</label>
          <input type="file" multiple/>
        </div>
        <div class="toolbar">
          <a class="btn ghost" href="portfolio.php">Cancel</a>
          <button class="btn primary" type="button" data-action="save">Save</button>
        </div>
      </form>
    </div>
  </main>
  <script src="/public/js/admin/script.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>
