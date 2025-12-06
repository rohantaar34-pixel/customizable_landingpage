<!-- booking-form.php -->
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php
// Database configuration
$host = 'localhost';
$dbname = 'inandout';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<section class="relative overflow-hidden min-h-screen bg-white">
    <div class="py-16 px-4 md:px-[10%] font-main">

        <!-- Back Button -->
        <button onclick="window.location.href='booking-time.php'"
            class="flex items-center text-[#3c5170] hover:text-[#fbb06b] transition-colors mb-8">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span class="text-sm font-light">Back to Time</span>
        </button>

        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-4xl md:text-5xl font-light text-[#3c5170] mb-4">Complete Your Booking</h1>
                <p class="text-lg text-gray-600">Just a few more details to confirm your appointment</p>
            </div>

            <!-- Booking Summary -->
            <div class="bg-gray-50 border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-light text-[#3c5170] mb-4">Booking Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Service:</span>
                        <span class="text-[#3c5170] font-light" id="summaryService">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="text-[#3c5170] font-light" id="summaryDate">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Time:</span>
                        <span class="text-[#3c5170] font-light" id="summaryTime">-</span>
                    </div>
                    <div class="border-t border-gray-200 mt-3 pt-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Base Price:</span>
                            <span class="text-[#3c5170] font-light" id="summaryBasePrice">$0.00</span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-gray-600">Add-ons Total:</span>
                            <span class="text-[#3c5170] font-light" id="summaryAddonsPrice">$0.00</span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-gray-600">GST (<span id="gstPercentage">0</span>%):</span>
                            <span class="text-[#3c5170] font-light" id="summaryGST">$0.00</span>
                        </div>
                        <div class="flex justify-between mt-3 pt-3 border-t border-gray-300">
                            <span class="text-[#3c5170] font-semibold">Estimated Total:</span>
                            <span class="text-[#fbb06b] font-semibold text-lg" id="summaryTotal">$0.00</span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4 italic">* Final price will be determined after on-site inspection
                </p>
            </div>

            <!-- Booking Form -->
            <form id="bookingForm" class="space-y-6">
                <input type="hidden" name="service_id" id="serviceId">
                <input type="hidden" name="base_price" id="basePrice">
                <input type="hidden" name="gst_rate" id="gstRate">

                <!-- Add-ons Selection -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-xl font-light text-[#3c5170] mb-4">Select Add-ons (Optional)</h3>
                    <div id="addonsContainer" class="space-y-3">
                        <!-- Add-ons will be loaded here -->
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-xl font-light text-[#3c5170] mb-4">Personal Information</h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Full Name *</label>
                            <input type="text" name="customer_name" required
                                class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Email Address *</label>
                            <input type="email" name="customer_email" required
                                class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm text-gray-600 mb-2">Phone Number *</label>
                        <input type="tel" name="customer_phone" required
                            class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                    </div>
                </div>

                <!-- Service Address -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-xl font-light text-[#3c5170] mb-4">Service Address</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Street Address *</label>
                            <input type="text" name="customer_address" required
                                class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                        </div>

                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">City *</label>
                                <input type="text" name="customer_city" required
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-2">State *</label>
                                <input type="text" name="customer_state" required
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-2">ZIP Code *</label>
                                <input type="text" name="customer_zip" required
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div class="pb-6">
                    <h3 class="text-xl font-light text-[#3c5170] mb-4">Additional Information</h3>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Special Instructions or Notes (Optional)</label>
                        <textarea name="notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 focus:border-[#fbb06b] focus:outline-none transition-colors"
                            placeholder="Any special requests, access instructions, or areas that need extra attention..."></textarea>
                    </div>
                </div>

                <!-- Terms -->
                <div class="border-t border-gray-200 pt-6">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="terms" required class="mt-1 mr-3">
                        <span class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-[#fbb06b] hover:text-[#3c5170]">terms and
                                conditions</a>
                            and <a href="#" class="text-[#fbb06b] hover:text-[#3c5170]">cancellation policy</a>
                        </span>
                    </label>
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="hidden bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-700">
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-6">
                    <button type="submit" id="submitBtn"
                        class="flex-1 py-4 bg-[#fbb06b] text-white hover:bg-[#3c5170] transition-colors duration-300 text-center font-light">
                        <span id="submitText">Confirm Booking</span>
                        <span id="submitLoader" class="hidden">Processing...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // booking-form.php JavaScript section - Replace the existing script
    let serviceData = null;
    let addonsData = [];
    let selectedAddons = [];

    document.addEventListener('DOMContentLoaded', async function () {
        console.log('Page loaded, initializing...'); // Debug

        // Load booking data from session storage
        let serviceRaw = sessionStorage.getItem('selectedService');
        const selectedDate = sessionStorage.getItem('selectedDate');
        const selectedTime = sessionStorage.getItem('selectedTime');

        console.log('Raw service string from sessionStorage:', serviceRaw); // Debug

        // Redirect if missing data
        if (!serviceRaw || !selectedDate || !selectedTime) {
            console.error('Missing required data, redirecting...');
            alert('Please complete the previous steps by selecting a service first.');
            window.location.href = 'services.php';
            return;
        }

        // Parse the JSON
        let service = JSON.parse(serviceRaw);
        console.log('Parsed service:', service); // Debug

        // Handle if service is an array (take first element)
        if (Array.isArray(service)) {
            console.log('Service is array, extracting first element');
            if (service.length === 0) {
                console.error('Service array is empty, redirecting...');
                window.location.href = 'services.php';
                return;
            }
            service = service[0];
        }

        console.log('Service after array check:', service); // Debug

        // Normalize the service data structure
        // Handle different possible field names
        const normalizedService = {
            id: service.id || '',
            name: service.service_name || service.name || '',
            service_name: service.service_name || service.name || '',
            service_desc: service.service_desc || service.description || '',
            price: parseFloat(service.price || service.basePrice || 0),
            gst: parseFloat(service.gst || service.gstFee || 0),
            addons: service.addons || [],
            total: parseFloat(service.total || 0)
        };

        console.log('Normalized service:', normalizedService); // Debug

        // Validate required fields
        if (!normalizedService.id || !normalizedService.name || normalizedService.price === 0) {
            console.error('Service missing required fields:', normalizedService);
            alert('Error loading service data. Please try selecting your service again.');
            window.location.href = 'services.php';
            return;
        }

        // Set global serviceData
        serviceData = normalizedService;

        console.log('Final serviceData set:', serviceData); // Debug log
        console.log('Price:', serviceData.price, 'GST:', serviceData.gst); // Debug

        // Update summary
        document.getElementById('summaryService').textContent = serviceData.name;
        document.getElementById('summaryDate').textContent = selectedDate + ' November 2025';
        document.getElementById('summaryTime').textContent = selectedTime;
        document.getElementById('serviceId').value = serviceData.id;
        document.getElementById('basePrice').value = serviceData.price;
        document.getElementById('gstRate').value = serviceData.gst;

        // Calculate GST percentage from dollar amount
        // Assuming GST is 10% of base price
        const gstPercentage = serviceData.price > 0 ? ((serviceData.gst / serviceData.price) * 100).toFixed(0) : 0;
        document.getElementById('gstPercentage').textContent = gstPercentage;

        // If addons were selected in calculator, pre-populate them
        if (serviceData.addons && serviceData.addons.length > 0) {
            console.log('Pre-selected addons from calculator:', serviceData.addons);
            // Store these temporarily to check them after loading
            window.preSelectedAddons = serviceData.addons;
        }

        // Load add-ons for this service from database
        await loadAddons(serviceData.id);

        // Wait a moment to ensure DOM is ready, then calculate
        setTimeout(() => {
            console.log('Running initial calculation...');
            calculateTotal();
        }, 200);
    });

    async function loadAddons(serviceId) {
        try {
            const response = await fetch(`get-addons.php?service_id=${serviceId}`);
            const result = await response.json();

            console.log('Addons loaded from database:', result); // Debug log

            if (result.success && result.addons.length > 0) {
                addonsData = result.addons;
                renderAddons(result.addons);

                // Check boxes for pre-selected addons from calculator
                if (window.preSelectedAddons && window.preSelectedAddons.length > 0) {
                    setTimeout(() => {
                        checkPreSelectedAddons();
                    }, 100);
                }
            } else {
                document.getElementById('addonsContainer').innerHTML =
                    '<p class="text-gray-500 text-sm">No add-ons available for this service.</p>';
            }
        } catch (error) {
            console.error('Error loading add-ons:', error);
            document.getElementById('addonsContainer').innerHTML =
                '<p class="text-red-500 text-sm">Failed to load add-ons. Please refresh the page.</p>';
        }
    }

    function checkPreSelectedAddons() {
        console.log('Checking pre-selected addons...');
        const preSelected = window.preSelectedAddons || [];

        preSelected.forEach(addon => {
            // Find checkbox by addon name (case-insensitive match)
            const checkboxes = document.querySelectorAll('.addon-checkbox');
            checkboxes.forEach(checkbox => {
                const checkboxName = checkbox.dataset.name.toLowerCase().trim();
                const addonName = addon.name.toLowerCase().trim();

                if (checkboxName === addonName) {
                    console.log('Checking addon:', addon.name);
                    checkbox.checked = true;
                }
            });
        });

        // Update selected addons after checking boxes
        updateSelectedAddons();
    }

    function renderAddons(addons) {
        const container = document.getElementById('addonsContainer');
        container.innerHTML = addons.map(addon => {
            const addonPrice = parseFloat(addon.price) || 0;
            return `
        <label class="flex items-start cursor-pointer p-4 border border-gray-200 hover:border-[#fbb06b] transition-colors">
            <input type="checkbox" 
                   name="addons[]" 
                   value="${addon.id}" 
                   data-price="${addonPrice}"
                   data-name="${escapeHtml(addon.adds_on)}"
                   class="mt-1 mr-3 addon-checkbox"
                   onchange="updateSelectedAddons()">
            <div class="flex-1">
                <span class="text-[#3c5170] font-light">${escapeHtml(addon.adds_on)}</span>
                <span class="text-[#fbb06b] ml-2">+$${addonPrice.toFixed(2)}</span>
            </div>
        </label>
    `;
        }).join('');
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    function updateSelectedAddons() {
        selectedAddons = [];
        document.querySelectorAll('.addon-checkbox:checked').forEach(checkbox => {
            selectedAddons.push({
                id: checkbox.value,
                name: checkbox.dataset.name,
                price: parseFloat(checkbox.dataset.price) || 0
            });
        });
        console.log('Selected addons updated:', selectedAddons);
        calculateTotal();
    }

    function calculateTotal() {
        // Ensure serviceData exists and has valid price/gst
        if (!serviceData || serviceData.price === undefined) {
            console.error('Service data not loaded properly:', serviceData);
            return;
        }

        const basePrice = parseFloat(serviceData.price) || 0;
        const gstAmount = parseFloat(serviceData.gst) || 0;

        console.log('Calculating with basePrice:', basePrice, 'gstAmount:', gstAmount); // Debug

        // Calculate addons total
        const addonsTotal = selectedAddons.reduce((sum, addon) => {
            const addonPrice = parseFloat(addon.price) || 0;
            return sum + addonPrice;
        }, 0);

        // Calculate subtotal (base + addons)
        const subtotal = basePrice + addonsTotal;

        // For GST, we need to recalculate based on new subtotal
        // Get the GST rate from the base price and gst amount
        let gstRate = 0;
        if (basePrice > 0 && gstAmount > 0) {
            gstRate = (gstAmount / basePrice) * 100;
        }

        // Calculate new GST on the subtotal
        const gst = subtotal * (gstRate / 100);

        // Calculate total
        const total = subtotal + gst;

        console.log('Calculation breakdown:', {
            basePrice,
            addonsTotal,
            subtotal,
            gstRate,
            gst,
            total
        });

        // Update display with proper formatting
        document.getElementById('summaryBasePrice').textContent = `$${basePrice.toFixed(2)}`;
        document.getElementById('summaryAddonsPrice').textContent = `$${addonsTotal.toFixed(2)}`;
        document.getElementById('summaryGST').textContent = `$${gst.toFixed(2)}`;
        document.getElementById('summaryTotal').textContent = `$${total.toFixed(2)}`;
    }

    // Form submission
    document.getElementById('bookingForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitLoader = document.getElementById('submitLoader');
        const errorMessage = document.getElementById('errorMessage');

        // Disable submit button
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoader.classList.remove('hidden');
        errorMessage.classList.add('hidden');

        // Get form data
        const formData = new FormData(this);

        // Add booking details from session storage
        const selectedDate = sessionStorage.getItem('selectedDate');
        const selectedTime = sessionStorage.getItem('selectedTime');

        formData.append('service', serviceData.name);
        formData.append('booking_date', selectedDate);
        formData.append('booking_time', selectedTime);

        // Add selected addons as JSON
        formData.append('selected_addons', JSON.stringify(selectedAddons));

        // Calculate prices
        const basePrice = parseFloat(serviceData.price);
        const addonsTotal = selectedAddons.reduce((sum, addon) => sum + parseFloat(addon.price), 0);
        const subtotal = basePrice + addonsTotal;

        // Calculate GST rate and amount
        const gstAmount = parseFloat(serviceData.gst) || 0;
        let gstRate = 0;
        if (basePrice > 0 && gstAmount > 0) {
            gstRate = (gstAmount / basePrice);
        }
        const gst = subtotal * gstRate;
        const total = subtotal + gst;

        formData.append('estimated_subtotal', subtotal.toFixed(2));
        formData.append('estimated_gst', gst.toFixed(2));
        formData.append('estimated_total', total.toFixed(2));

        try {
            const response = await fetch('process-booking.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Clear session storage
                sessionStorage.removeItem('selectedService');
                sessionStorage.removeItem('selectedDate');
                sessionStorage.removeItem('selectedTime');

                // Redirect to success page
                window.location.href = 'booking-success.php?ref=' + result.booking_ref;
            } else {
                // Show error message
                errorMessage.textContent = result.message || 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');

                // Re-enable submit button
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                submitLoader.classList.add('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred. Please try again.';
            errorMessage.classList.remove('hidden');

            // Re-enable submit button
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoader.classList.add('hidden');
        }
    });
</script>

<?php include "includes/footer.php" ?>