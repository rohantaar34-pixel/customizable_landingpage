<!-- Contact us page, contact form -->
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<section class="relative overflow-hidden  hero-section min-h-screen flex flex-col">
    <div class="py-5 px-4 md:px-[10%] flex flex-col font-main relative z-10">
        <div class="py-16 px-4 md:px-[10%] font-main max-w-4xl mx-auto w-full">

            <!-- Header -->

            <?php
            // Display success message
            if (isset($_GET['success']) && isset($_SESSION['contact_success'])) {
                echo '<div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>' . htmlspecialchars($_SESSION['contact_success']) . '</span>
                    </div>
                </div>';
                unset($_SESSION['contact_success']);
            }

            // Display error message
            if (isset($_GET['error']) && isset($_SESSION['contact_error'])) {
                echo '<div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>' . htmlspecialchars($_SESSION['contact_error']) . '</span>
                    </div>
                </div>';
                unset($_SESSION['contact_error']);
            }
            ?>

            <!-- Contact Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 md:p-10">
                <div class="mb-8">
                    <button onclick="window.history.back()"
                        class="text-gray-500 hover:text-gray-700 mb-4 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                    <h1 class="text-4xl md:text-5xl font-bold text-[#3d5a80] mb-3">Get In Touch</h1>
                    <p class="text-lg text-gray-600">We'd love to hear from you. Send us a message and we'll respond as
                        soon
                        as possible.</p>
                </div>

                <form action="process_contact.php" method="POST" class="space-y-8" id="contactForm">

                    <!-- Contact Information Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#3d5a80] mb-6">Contact Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="full_name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3d5a80] focus:border-transparent outline-none transition"
                                    placeholder="John Doe" />
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3d5a80] focus:border-transparent outline-none transition"
                                    placeholder="john@example.com" />
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3d5a80] focus:border-transparent outline-none transition"
                                placeholder="+1 (555) 000-0000" />
                        </div>
                    </div>

                    <!-- Service Details Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#3d5a80] mb-6">Service Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Interested In <span class="text-red-500">*</span>
                                </label>
                                <select name="service_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3d5a80] focus:border-transparent outline-none transition bg-white">
                                    <option value="">Select a service...</option>
                                    <option value="deep_cleaning">Deep Cleaning</option>
                                    <option value="regular_cleaning">Regular Cleaning</option>
                                    <option value="move_in_out">Move In/Out Cleaning</option>
                                    <option value="office_cleaning">Office Cleaning</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Preferred Contact Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Preferred Contact Method
                                </label>
                                <input type="text" name="contact_method" value="Email" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md bg-gray-100 text-gray-700 cursor-not-allowed outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- Message Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#3d5a80] mb-6">Your Message</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" required rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3d5a80] focus:border-transparent outline-none transition resize-none"
                                placeholder="Tell us about your cleaning needs, preferred schedule, or any questions you may have..."></textarea>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-start">
                        <input type="checkbox" name="agree_terms" id="agree_terms" required
                            class="mt-1 h-4 w-4 text-[#3d5a80] border-gray-300 rounded focus:ring-[#3d5a80]" />
                        <label for="agree_terms" class="ml-3 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-orange-500 hover:text-orange-600 underline">terms and
                                conditions</a> and <a href="#"
                                class="text-orange-500 hover:text-orange-600 underline">privacy policy</a>
                            <span class="text-red-500">*</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                        class="w-full btn-main text-white font-semibold py-4 px-6 rounded-md transition duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                        <span id="btnText">Send Message</span>
                        <svg id="loadingSpinner" class="hidden animate-spin ml-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Contact Info Cards -->

        </div>
    </div>

</section>

<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const loadingSpinner = document.getElementById('loadingSpinner');

        // Disable button and show loading state
        submitBtn.disabled = true;
        btnText.textContent = 'Sending...';
        loadingSpinner.classList.remove('hidden');
    });
</script>

<?php include "includes/footer.php" ?>