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
  <title>Profile Settings - Glow Edge</title>
  <link rel="stylesheet" href="/public/css/user/user-panel.css">
    <?php echo $csrf->getScriptTag(); ?>
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="/public/assets/ui/LOGO.png" alt="Glow Edge Logo">
    </div>
    <a href="/home" data-page="home">Back to Home</a>
    <a href="/user/my_booking" data-page="bookings">My Bookings</a>
    <a href="/user/profile_settings" class="active" data-page="profile">Profile Settings</a>
    <a style="cursor: pointer"  class="logout" id="logoutButton" >Logout</a>
  </div>

  <div class="main">
    <header>
      <h2>Profile Settings</h2>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span class="welcome" id="welcomeUser">Welcome, <?php echo $data['name'] ?> </span>
            <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                <img src="<?php echo $user->getProfilePic(); ?>"
                     alt="Profile pic"
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

    </header>

    <form class="profile-form" id="profileForm" action="/user/update" method="POST" >
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name"  id="name" value="<?php echo $data['name'] ?>">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" id="email" value="<?php echo $data['email'] ?>">
      </div>
      <div class="form-group">
        <label>Telephone No</label>
        <input type="text" name="phone" id="telephone" value="<?php echo $data['phone'] ?>">
      </div>
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" id="address" value="<?php echo $data['address'] ?>">
      </div>
      <div class="form-group">
        <label>WhatsApp No</label>
        <input type="text" name="whatsapp" id="whatsapp" value="<?php echo $data['whatsapp'] ?>">
      </div>
      <div class="form-group">
        <label>Profile Picture</label>
        <input type="file" accept="image/*" name="profilePic" id="profilePic">
          <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; margin-top: 10px;">
              <img src="<?php echo $user->getProfilePic(); ?>"
                   alt="Profile pic"
                   style="width: 100%; height: 100%; object-fit: cover;">
          </div>

      </div>

      <button style="" type="submit">Save</button>

        <!-- CSRF Token -->
        <?php
        echo $csrf->getInputHtml();
        ?>

    </form>
  </div>


  <script type="module" src="/public/js/user/update_profile.js"></script>
  <script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>
