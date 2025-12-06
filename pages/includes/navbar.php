<nav class="w-full py-4 px-6 md:px-[10%] shadow-xl flex flex-row items-center sticky top-0 bg-white navbar" id="navbar">
    <img src="../images/logo.png" class="w-[150px]" alt="">

    <!-- Mobile Toggle Button -->
    <button id="menuToggle" class="ml-auto md:hidden text-gray-700 focus:outline-none">
        <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Desktop Menu -->
    <div class="hidden md:flex ml-auto">
        <a href="home.php"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 text-xl">Home</a>
        <a href="about.php"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 text-xl">About</a>
        <a href="services.php"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 text-xl">Services</a>
        <a href="testimonials.php"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 text-xl">Reviews</a>
        <a href="contact.php"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 text-xl">Contacts Us</a>
    </div>
</nav>

<!-- Mobile Menu -->
<div id="mobileMenu"
    class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden">
    <div class="flex flex-col pt-20 px-6">
        <a href="home.php"
            class="py-3 text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-4 rounded transition-all duration-200 font-medium">Home</a>
        <a href="about.php"
            class="py-3 text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-4 rounded transition-all duration-200 font-medium">About</a>
        <a href="services.php"
            class="py-3 text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-4 rounded transition-all duration-200 font-medium">Services</a>
        <a href="testimonials.php"
            class="py-3 text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-4 rounded transition-all duration-200 font-medium">Reviews</a>
        <a href="contact.php"
            class="py-3 text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-4 rounded transition-all duration-200 font-medium">Contacts</a>
    </div>
</div>

<!-- Overlay -->
<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40 md:hidden transition-opacity duration-300">
</div>