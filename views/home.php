<?php

use controller\Booking;
use controller\Portfolio;
use controller\User;
use middleware\Auth;


$booking = new Booking();
$portfolio = new Portfolio();
$user = new User();
$auth = new Auth();

?>

<!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Tailwind CSS CDN -->
    <link rel="stylesheet" href="/public/css/tailwindcss/output.css">
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .brand-bg {
            background-color: #604c84;
        }
        .brand-text {
            color: #604c84;
        }
        .brand-border {
            border-color: #604c84;
        }
        .transition-all-300 {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Header & Navigation blur background -->
<header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/home" class="text-2xl font-bold brand-text">LOGO</a>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden">
            <button id="menu-btn" class="text-gray-800 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center space-x-6">
            <a href="/home" class="text-gray-600 hover:brand-text transition-all-300">Home</a>
            <a href="#services" class="text-gray-600 hover:brand-text transition-all-300">Services</a>
            <a href="#portfolio" class="text-gray-600 hover:brand-text transition-all-300">Portfolio</a>
            <a href="#testimonials" class="text-gray-600 hover:brand-text transition-all-300">About Us</a>
            <a href="#" class="text-gray-600 hover:brand-text transition-all-300">Contact Us</a>
        </div>

        <!-- Sign Up / Sign In Buttons -->
        <div class="hidden lg:flex items-center space-x-4">
            <?php if (!$auth->isLoggedIn()): ?>
                <a href="/user/login" class="text-gray-600 hover:brand-text transition-all-300">Sign In</a>
                <a href="/user/signup" class="brand-bg text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all-300 shadow-sm">Sign Up</a>
            <?php else: ?>
                <?php if ($auth->isAdminLoggedIn()): ?>
                    <a href="/admin/dashboard" class="border-2 border-gray-300 text-gray-600 px-4 py-2 rounded-lg hover:opacity-90 transition-all-300">Admin Dashboard</a>
                <?php endif; ?>
                <a href="/user/my_booking" class="brand-bg text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all-300 shadow-sm">Dashboard</a>
                <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                    <img src="<?php echo $user->getProfilePic(); ?>"
                         alt="Profile pic"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white px-6 pb-4 space-y-2">
        <a href="/home" class="block text-gray-600 hover:brand-text transition-all-300 py-2">Home</a>
        <a href="#services" class="block text-gray-600 hover:brand-text transition-all-300 py-2">Services</a>
        <a href="#portfolio" class="block text-gray-600 hover:brand-text transition-all-300 py-2">Portfolio</a>
        <a href="#testimonials" class="block text-gray-600 hover:brand-text transition-all-300 py-2">About Us</a>
        <a href="#" class="block text-gray-600 hover:brand-text transition-all-300 py-2">Contact Us</a>
        <hr>
        <?php if (!$auth->isLoggedIn()): ?>
            <a href="/user/login" class="block text-gray-600 hover:brand-text transition-all-300 py-2">Sign In</a>
            <a href="/user/signup" class="block brand-bg text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all-300 text-center">Sign Up</a>
        <?php else: ?>
            <div class="flex items-center space-x-4 pt-2">
                <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                    <img src="<?php echo $user->getProfilePic(); ?>"
                         alt="Profile pic"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <a href="/user/my_booking" class="brand-bg text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all-300 shadow-sm block w-full text-center">Dashboard</a>
            </div>
            <?php if ($auth->isAdminLoggedIn()): ?>
                <a href="/admin/dashboard" class="block border-2 border-gray-300 text-gray-600 px-4 py-2 rounded-lg hover:opacity-90 transition-all-300 text-center mt-2">Admin Dashboard</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>

<main>
    <!-- Hero Section -->
    <section class="relative text-white min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/public/assets/ui/hiro.jpg"
                 alt="Hero Background"
                 class="w-full h-full object-cover">
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-45"></div>

        <!-- Hero Content -->
        <div class="relative container mx-auto px-6 py-12 flex flex-col items-center text-center">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight drop-shadow-lg">
                Capturing Moments,<br class="hidden md:block"> Crafting <span class="brand-text">Visions</span>.
            </h1>
            <p class="mt-6 max-w-2xl text-lg md:text-xl text-gray-200 drop-shadow-md">
                Creative photography and graphic design that bring your stories to life. Let's create something unforgettable together.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#services" class="w-full sm:w-auto brand-bg text-white px-8 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition-all-300 shadow-lg transform hover:scale-105">
                    Explore Services
                </a>
                <a href="#portfolio" class="w-full sm:w-auto bg-white text-gray-800 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-all-300 shadow-lg border border-transparent transform hover:scale-105">
                    View Portfolio
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900">Our Services</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">We offer a full suite of creative services to help you achieve your goals.</p>
            </div>
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all-300">
                    <img src="https://placehold.co/600x400/604c84/FFFFFF?text=Service+1" alt="Service 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Wedding Photography</h3>
                        <p class="text-gray-600 mb-4">Capturing your special moments with artistry and passion.</p>
                        <button class="w-full brand-bg text-white py-2 rounded-lg hover:opacity-90 transition-all-300">Book Now</button>
                    </div>
                </div>
                <!-- Service Card 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all-300">
                    <img src="https://placehold.co/600x400/eeeeee/333333?text=Service+2" alt="Service 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Product Photography</h3>
                        <p class="text-gray-600 mb-4">Showcasing your products in the best possible light.</p>
                        <button class="w-full brand-bg text-white py-2 rounded-lg hover:opacity-90 transition-all-300">Book Now</button>
                    </div>
                </div>
                <!-- Service Card 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all-300">
                    <img src="https://placehold.co/600x400/604c84/FFFFFF?text=Service+3" alt="Service 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Event Coverage</h3>
                        <p class="text-gray-600 mb-4">Documenting your corporate events, parties, and more.</p>
                        <button class="w-full brand-bg text-white py-2 rounded-lg hover:opacity-90 transition-all-300">Book Now</button>
                    </div>
                </div>
                <!-- Service Card 4 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all-300">
                    <img src="https://placehold.co/600x400/eeeeee/333333?text=Service+4" alt="Service 4" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Portrait Sessions</h3>
                        <p class="text-gray-600 mb-4">Creating timeless portraits for individuals and families.</p>
                        <button class="w-full brand-bg text-white py-2 rounded-lg hover:opacity-90 transition-all-300">Book Now</button>
                    </div>
                </div>
                <!-- Service Card 5 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all-300">
                    <img src="https://placehold.co/600x400/604c84/FFFFFF?text=Service+5" alt="Service 5" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Real Estate</h3>
                        <p class="text-gray-600 mb-4">High-quality photos to make your listings stand out.</p>
                        <button class="w-full brand-bg text-white py-2 rounded-lg hover:opacity-90 transition-all-300">Book Now</button>
                    </div>
                </div>
                <!-- Service Card 6 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all-300">
                    <img src="https://placehold.co/600x400/eeeeee/333333?text=Service+6" alt="Service 6" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Videography</h3>
                        <p class="text-gray-600 mb-4">Cinematic videos that tell a compelling story.</p>
                        <button class="w-full brand-bg text-white py-2 rounded-lg hover:opacity-90 transition-all-300">Book Now</button>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <button class="border-2 brand-border brand-text font-semibold py-2 px-8 rounded-lg hover:brand-bg hover:text-white transition-all-300">View All</button>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900">Our Portfolio</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">A glimpse into our diverse work, showcasing our passion and craftsmanship.</p>
            </div>
            <!-- Portfolio Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Portfolio Item 1 -->
                <div class="group relative rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x600/604c84/FFFFFF?text=Project+1" alt="Project 1" class="w-full h-full object-cover transform group-hover:scale-110 transition-all-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all-300">
                        <h3 class="text-white text-2xl font-bold">Project 1</h3>
                    </div>
                </div>
                <!-- Portfolio Item 2 -->
                <div class="group relative rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x600/eeeeee/333333?text=Project+2" alt="Project 2" class="w-full h-full object-cover transform group-hover:scale-110 transition-all-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all-300">
                        <h3 class="text-white text-2xl font-bold">Project 2</h3>
                    </div>
                </div>
                <!-- Portfolio Item 3 -->
                <div class="group relative rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x600/604c84/FFFFFF?text=Project+3" alt="Project 3" class="w-full h-full object-cover transform group-hover:scale-110 transition-all-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all-300">
                        <h3 class="text-white text-2xl font-bold">Project 3</h3>
                    </div>
                </div>
                <!-- Portfolio Item 4 -->
                <div class="group relative rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x600/eeeeee/333333?text=Project+4" alt="Project 4" class="w-full h-full object-cover transform group-hover:scale-110 transition-all-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all-300">
                        <h3 class="text-white text-2xl font-bold">Project 4</h3>
                    </div>
                </div>
                <!-- Portfolio Item 5 -->
                <div class="group relative rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x600/604c84/FFFFFF?text=Project+5" alt="Project 5" class="w-full h-full object-cover transform group-hover:scale-110 transition-all-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all-300">
                        <h3 class="text-white text-2xl font-bold">Project 5</h3>
                    </div>
                </div>
                <!-- Portfolio Item 6 -->
                <div class="group relative rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x600/eeeeee/333333?text=Project+6" alt="Project 6" class="w-full h-full object-cover transform group-hover:scale-110 transition-all-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all-300">
                        <h3 class="text-white text-2xl font-bold">Project 6</h3>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <button class="border-2 brand-border brand-text font-semibold py-2 px-8 rounded-lg hover:brand-bg hover:text-white transition-all-300">View More</button>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900">What Our Clients Say</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">We're proud of the relationships we build and the feedback we've received.</p>
            </div>
            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial Card 1 -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/100x100/604c84/FFFFFF?text=A" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-semibold">Anna Clark</p>
                            <p class="text-sm text-gray-500">Wedding Client</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"The photography for our wedding was absolutely stunning. They captured every moment perfectly. We couldn't be happier with the results!"</p>
                </div>
                <!-- Testimonial Card 2 -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/100x100/eeeeee/333333?text=J" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-semibold">John Doe</p>
                            <p class="text-sm text-gray-500">Corporate Client</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"Professional, creative, and delivered on time. The product shots have significantly boosted our online sales. Highly recommended."</p>
                </div>
                <!-- Testimonial Card 3 -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/100x100/604c84/FFFFFF?text=S" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-semibold">Sarah Miller</p>
                            <p class="text-sm text-gray-500">Family Portraits</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"They were so patient with our kids and managed to get the most amazing family photos. We will cherish these forever."</p>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="brand-bg text-white">
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-xl font-bold mb-4">LOGO</h3>
                <p class="text-gray-300">Creative services to help you achieve your goals.</p>
            </div>
            <!-- Links -->
            <div>
                <h3 class="font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-all-300">Home</a></li>
                    <li><a href="#services" class="text-gray-300 hover:text-white transition-all-300">Services</a></li>
                    <li><a href="#portfolio" class="text-gray-300 hover:text-white transition-all-300">Portfolio</a></li>
                    <li><a href="#testimonials" class="text-gray-300 hover:text-white transition-all-300">Testimonials</a></li>
                </ul>
            </div>
            <!-- Social -->
            <div>
                <h3 class="font-semibold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white transition-all-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-all-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-all-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.345 2.525c.636-.247 1.363-.416 2.427-.465C9.793 2.013 10.147 2 12.315 2zm0 1.623c-2.403 0-2.73.01-3.685.053-.934.042-1.558.196-2.095.396a3.287 3.287 0 00-1.18 1.18c-.2.537-.354 1.16-.396 2.095-.043.955-.053 1.282-.053 3.685s.01 2.73.053 3.685c.042.934.196 1.558.396 2.095a3.287 3.287 0 001.18 1.18c.537.2 1.16.354 2.095.396.955.043 1.282.053 3.685.053s2.73-.01 3.685-.053c.934-.042 1.558-.196 2.095-.396a3.287 3.287 0 001.18-1.18c.2-.537.354-1.16.396-2.095.043-.955.053-1.282.053-3.685s-.01-2.73-.053-3.685c-.042-.934-.196-1.558-.396-2.095a3.287 3.287 0 00-1.18-1.18c-.537-.2-1.16-.354-2.095-.396-.955-.043-1.282-.053-3.685-.053zM12 8.118a3.882 3.882 0 100 7.764 3.882 3.882 0 000-7.764zM12 14.3a2.3 2.3 0 110-4.6 2.3 2.3 0 010 4.6zm4.965-8.21a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
            <!-- Contact -->
            <div>
                <h3 class="font-semibold mb-4">Contact Us</h3>
                <p class="text-gray-300">123 Creative Lane<br>Design City, DC 12345<br>contact@logo.com</p>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400">
            <p>&copy; 2024 LOGO. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    // JavaScript for mobile menu toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>




