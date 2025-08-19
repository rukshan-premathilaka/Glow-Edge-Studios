<?php

$booking = new \controller\Booking();
$portfolio = new \controller\Portfolio();
$service = new \controller\Service();
$csrf = new \middleware\CsrfToken();
$user = new \controller\User();

$data = $booking->getDetails();

/*echo "<pre>";
print_r($data);
echo "</pre>";*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Panel · Booking Details</title>
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
        <div class="welcome">Admin Panel · Booking Details</div>
        <div class="profile-wrap"><span class="profile-name">Welcome, <?php echo $user->getUserName();?></span>
            <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                <img src="<?php echo $user->getProfilePic(); ?>"
                     alt="Profile pic"
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="dropdown"><a href="bookings.php">Back to Bookings</a></div>
        </div>
    </div>

    <div class="container grid cols-3">
        <div class="card" style="grid-column:span 2;">
            <div class="section-title"><?php echo $data['title']; ?></div>
            <div class="muted">Client: <?php echo $data['name']; ?> · Booked Date: <?php echo date('Y-m-d', strtotime($data['created_at'])); ?></div>
            <div class="spacer"></div>
            <p>Client Message: <?php echo $data['client_message']; ?></p>
            <div class="spacer"></div>
            <div class="toolbar">
                <button class="btn" data-action="confirm" data-name="this booking">Confirm Booking</button>
                <button class="btn warn" data-action="cancel" data-name="this booking">Cancel Booking</button>
            </div>
        </div>

        <div class="card">
            <div class="section-title">Client</div>
            <div style="display:flex;gap:10px;align-items:center;margin-top:10px">
                <img id="profilePreview" src="<?php echo $user->getProfilePic($data['user_id']); ?>" style="width:44px;height:44px;border-radius:50%;border:2px solid var(--sidebar)" alt="Profile Picture">
                <div><strong><?php echo $data['name']; ?></strong><div class="muted"><?php echo $data['address'] ? $data['address'] : 'Address not provided'; ?></div></div>
            </div>
            <div class="spacer"></div>
            <button class="btn ghost" onclick="flash('Message sent')">Send Message</button>
        </div>

        <div class="card" style="grid-column:span 3;">
            <div class="section-title">Review</div>
            <textarea placeholder="Add an review" style="width:100%;min-height:110px;margin-top:8px"></textarea>
            <div class="toolbar"><button class="btn primary" data-action="save">Add Review</button></div>
        </div>
    </div>
</main>
<script src="/public/js/admin/script.js"></script>
<script type="module" src="/public/js/user/logout.js"></script>
</body>
</html>