<!-- booking-time.php -->
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<section class="relative overflow-hidden min-h-screen bg-white">
    <div class="py-16 px-4 md:px-[10%] font-main">

        <!-- Back Button -->
        <button onclick="window.location.href='booking-date.php'"
            class="flex items-center text-[#3c5170] hover:text-[#fbb06b] transition-colors mb-8">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span class="text-sm font-light">Back to Date</span>
        </button>

        <div class="max-w-4xl mx-auto">
            <!-- Service Info & Estimate -->
            <div class="mb-12">
                <h2 class="text-4xl font-light text-[#3c5170] mb-4" id="serviceName">Loading...</h2>

                <!-- Estimate Summary -->
                <div class="bg-gradient-to-br from-[#f0f4f8] to-[#e8eef3] rounded-lg p-6 border-l-4 border-[#fbb06b]">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Selected Date</p>
                            <p class="font-semibold text-[#3c5170]" id="selectedDateDisplay">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Estimated Total</p>
                            <p class="text-2xl font-bold text-[#fbb06b]" id="estimatedTotal">$0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Selection Header -->
            <div class="text-center mb-12">
                <h3 class="text-2xl font-light text-[#3c5170] mb-2">Select a Time</h3>
                <p class="text-sm text-gray-500">Your timezone: Asia/Singapore</p>
            </div>

            <!-- Time Slots -->
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Night -->
                <div>
                    <div class="text-center mb-6">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#3c5170]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <span class="text-sm font-light text-gray-700">Night</span>
                    </div>
                    <div class="space-y-3">
                        <button onclick="selectTime('3:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">3:30
                            AM</button>
                        <button onclick="selectTime('4:00 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">4:00
                            AM</button>
                        <button onclick="selectTime('4:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">4:30
                            AM</button>
                        <button onclick="selectTime('5:00 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">5:00
                            AM</button>
                        <button onclick="selectTime('5:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">5:30
                            AM</button>
                    </div>
                </div>

                <!-- Morning -->
                <div>
                    <div class="text-center mb-6">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#fbb06b]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="text-sm font-light text-gray-700">Morning</span>
                    </div>
                    <div class="space-y-3">
                        <button onclick="selectTime('6:00 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">6:00
                            AM</button>
                        <button onclick="selectTime('6:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">6:30
                            AM</button>
                        <button onclick="selectTime('7:00 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">7:00
                            AM</button>
                        <button onclick="selectTime('7:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">7:30
                            AM</button>
                        <button onclick="selectTime('10:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">10:30
                            AM</button>
                        <button onclick="selectTime('11:00 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">11:00
                            AM</button>
                        <button onclick="selectTime('11:30 AM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">11:30
                            AM</button>
                    </div>
                </div>

                <!-- Afternoon -->
                <div>
                    <div class="text-center mb-6">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#fbb06b]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="text-sm font-light text-gray-700">Afternoon</span>
                    </div>
                    <div class="space-y-3">
                        <button onclick="selectTime('12:00 PM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">12:00
                            PM</button>
                        <button onclick="selectTime('12:30 PM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">12:30
                            PM</button>
                        <button onclick="selectTime('1:00 PM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">1:00
                            PM</button>
                        <button onclick="selectTime('1:30 PM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">1:30
                            PM</button>
                        <button onclick="selectTime('2:00 PM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">2:00
                            PM</button>
                        <button onclick="selectTime('2:30 PM')"
                            class="w-full py-3 px-4 border border-[#3c5170] text-[#3c5170] hover:bg-[#3c5170] hover:text-white transition-all duration-200 text-sm font-light">2:30
                            PM</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    // booking-time.php JavaScript - Replace the existing script section
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Booking time page loaded');

        const serviceRaw = sessionStorage.getItem('selectedService');
        const selectedDate = sessionStorage.getItem('selectedDate');

        console.log('Service raw:', serviceRaw);
        console.log('Selected date:', selectedDate);

        if (!serviceRaw || !selectedDate) {
            console.error('Missing required data');
            alert('Please complete the previous steps');
            window.location.href = 'services.php';
            return;
        }

        try {
            let service = JSON.parse(serviceRaw);
            console.log('Parsed service:', service);

            // Handle if service is an array
            if (Array.isArray(service)) {
                console.log('Service is array, taking first element');
                service = service[0];
            }

            // Get service name and total
            const serviceName = service.service_name || service.name || 'Service';
            const total = parseFloat(service.total || 0);

            console.log('Service name:', serviceName);
            console.log('Total:', total);

            document.getElementById('serviceName').textContent = serviceName;
            document.getElementById('selectedDateDisplay').textContent = selectedDate;
            document.getElementById('estimatedTotal').textContent = '$' + total.toFixed(2);

        } catch (error) {
            console.error('Error parsing service data:', error);
            alert('Error loading service data. Please try again.');
            window.location.href = 'services.php';
            return;
        }
    });

    function selectTime(time) {
        console.log('Time selected:', time);
        sessionStorage.setItem('selectedTime', time);
        window.location.href = 'booking-form.php';
    }
</script>

<?php include "includes/footer.php" ?>