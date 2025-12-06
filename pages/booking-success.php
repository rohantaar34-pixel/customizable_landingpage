<!-- booking-success.php -->
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php
$booking_ref = isset($_GET['ref']) ? htmlspecialchars($_GET['ref']) : '';
?>

<section class="relative overflow-hidden min-h-screen bg-white flex items-center">
    <div class="py-16 px-4 md:px-[10%] font-main w-full">

        <div class="max-w-2xl mx-auto text-center">

            <!-- Success Icon -->
            <div class="mb-8">
                <div class="w-24 h-24 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-4xl md:text-5xl font-light text-[#3c5170] mb-6">Booking Confirmed!</h1>

            <p class="text-lg text-gray-600 mb-8">
                Your appointment has been successfully scheduled. You will receive a confirmation email shortly with all
                the details.
            </p>

            <?php if ($booking_ref): ?>
                <div class="bg-gray-50 border-l-4 border-[#fbb06b] p-6 mb-8">
                    <p class="text-sm text-gray-600 mb-2">Your booking reference:</p>
                    <p class="text-2xl font-light text-[#3c5170]"><?php echo $booking_ref; ?></p>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="services.php"
                    class="px-8 py-3 bg-[#fbb06b] text-white hover:bg-[#3c5170] transition-colors duration-300">
                    Book Another Service
                </a>
                <a href="home.php"
                    class="px-8 py-3 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-colors duration-300">
                    Return to Home
                </a>
            </div>

            <!-- Additional Info -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-xl font-light text-[#3c5170] mb-4">What's Next?</h3>
                <div class="grid md:grid-cols-3 gap-6 text-left">
                    <div class="p-4 bg-gray-50">
                        <div
                            class="w-10 h-10 bg-[#fbb06b] rounded-full flex items-center justify-center text-white font-light mb-3">
                            1</div>
                        <h4 class="font-light text-[#3c5170] mb-2">Confirmation Email</h4>
                        <p class="text-sm text-gray-600">Check your inbox for booking details and receipt</p>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <div
                            class="w-10 h-10 bg-[#fbb06b] rounded-full flex items-center justify-center text-white font-light mb-3">
                            2</div>
                        <h4 class="font-light text-[#3c5170] mb-2">Reminder</h4>
                        <p class="text-sm text-gray-600">We'll send you a reminder 24 hours before</p>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <div
                            class="w-10 h-10 bg-[#fbb06b] rounded-full flex items-center justify-center text-white font-light mb-3">
                            3</div>
                        <h4 class="font-light text-[#3c5170] mb-2">Service Day</h4>
                        <p class="text-sm text-gray-600">Our team arrives on time, ready to clean</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php" ?>