<footer class="w-full py-8 px-[10%] min-h-[200px] z-10 font-main bg-white text-[#20160d]">
    <div class="w-full flex flex-row gap-8">
        <!-- Logo & ABN Section -->
        <div class="flex flex-col space-y-3 w-[30%] mr-[7%]">
            <img src="../images/logo.png" class="w-[140px] bg-white rounded-xl " alt="In and Out Cleaning Logo">
            <p class="text-justify c-text">We provide reliable and high-quality cleaning services for homes and
                businesses. Our team ensures every space is spotless, organized, and cared for with excellence.</p>
        </div>

        <!-- Quick Links Section -->
        <div class="flex flex-col space-y-3 w-[30%]">
            <h3 class="text-lg font-semibold mb-2 text-[#3c5170]">Quick Links</h3>
            <a href="index.php" class="text-sm hover:underline hover:opacity-80 transition-opacity">Home</a>
            <a href="about.php" class="text-sm hover:underline hover:opacity-80 transition-opacity">About Us</a>
            <a href="services.php" class="text-sm hover:underline hover:opacity-80 transition-opacity">Services</a>
            <button onclick="openModal('terms')"
                class="text-sm hover:underline hover:opacity-80 transition-opacity text-left bg-transparent border-0 p-0 font-inherit cursor-pointer">Terms
                and Conditions</button>
            <button onclick="openModal('privacy')"
                class="text-sm hover:underline hover:opacity-80 transition-opacity text-left bg-transparent border-0 p-0 font-inherit cursor-pointer">Privacy
                Policy</button>
        </div>

        <!-- Social Media Section -->
        <div class="flex flex-col space-y-3 w-[30%] mr-[5%]">
            <h3 class="text-lg font-semibold mb-2 text-[#3c5170]">Connect With Us</h3>
            <a href="https://www.facebook.com/profile.php?id=61582642147262&mibextid=wwXIfr&rdid=hydT1ORlkSa5ha7E&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F15iTAzJZgB%2F%3Fmibextid%3DwwXIfr#"
                target="_blank" class="flex items-center space-x-2 text-sm hover:opacity-80 transition-opacity">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                <span>Facebook</span>
            </a>
            <a href="https://instagram.com" target="_blank"
                class="flex items-center space-x-2 text-sm hover:opacity-80 transition-opacity">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
                <span>Instagram</span>
            </a>
            <a href="mailto:Admin@iocleaningexperts.com.au"
                class="flex items-center space-x-2 text-sm hover:opacity-80 transition-opacity">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                </svg>
                <span>admin@iocleaningexperts.com.au</span>
            </a>
            <a href="tel:0431491143" class="flex items-center space-x-2 text-sm hover:opacity-80 transition-opacity">
                <i class="fa-solid fa-phone"></i>
                <span>0431491143</span>
            </a>
        </div>

        <!-- Location Section -->
        <div class="flex flex-col space-y-3 w-[30%]">
            <h3 class="text-lg font-semibold mb-2 text-[#3c5170]">Servicing Area</h3>
            <a href="https://www.google.com/maps/place/Adelaide+SA,+Australia/@-34.9281805,138.5179456,12z"
                target="_blank"
                class="flex items-start space-x-2 text-sm hover:underline hover:opacity-80 transition-opacity group">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                </svg>
                <span>Adelaide, South Australia</span>
            </a>
            <img class="mx-1 py-1 image-footer-logo" src="../images/ichoosesa-1.png" alt="">
        </div>
    </div>
</footer>

<div
    class="w-full px-[10%] font-main py-[2%] border-t border-[#6d523c]/20 text-center btn-main text-[#273449] flex flex-row items-center justify-center font-bold">
    <p class="text-sm mx-1">&copy; <?php echo date('Y'); ?> In and Out Cleaning Experts </p> |
    <p class="text-sm mx-1">ABN: 22 420 575 770</p> |
    <a class="text-sm mx-1" href="https://zerohan.site">Designed and Developed by ZEROHAN</a>
</div>

<!-- Privacy Policy & Terms Modal -->
<div id="policyModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
    <div id="policyBackdrop" class="fixed inset-0 bg-black/60 transition-all duration-300" onclick="closeModal()"></div>

    <div class="flex min-h-screen items-start justify-center p-4 pt-8">
        <div id="policyModalContent"
            class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[85vh] overflow-hidden transform transition-all duration-500 translate-y-[-100vh] opacity-0">

            <!-- Modal Header -->
            <div
                class="sticky top-0 bg-gradient-to-r from-[#3c5170] to-[#273449] px-6 py-4 border-b border-gray-200 flex justify-between items-center z-10">
                <h2 id="modalTitle" class="text-2xl font-bold text-white">Privacy Policy</h2>
                <button onclick="closeModal()"
                    class="text-white hover:text-gray-200 hover:bg-white/20 rounded-full p-2 transition-all duration-300 hover:rotate-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div id="modalContent" class="px-8 py-6 overflow-y-auto max-h-[calc(85vh-120px)] text-gray-800">
                <!-- Content will be dynamically inserted here -->
            </div>

            <!-- Modal Footer -->
            <div
                class="sticky bottom-0 bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button onclick="closeModal()"
                    class="bg-[#3c5170] text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#273449] transition-all duration-300 shadow-md hover:shadow-lg">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const privacyContent = `
        <div class="space-y-6">
            <p class="text-sm text-gray-600 italic">Effective Date: December 5, 2024</p>
            
            <p class="text-base leading-relaxed">
                At In & Out Cleaning Experts, we respect your privacy and are committed to protecting any personal information you share with us. This policy explains how we collect, use, and protect your information when you visit our website or use our cleaning services.
            </p>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">1. Information We Collect</h3>
                <p class="text-base leading-relaxed mb-2">We may collect personal information such as:</p>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>Your name, phone number, email address, and address</li>
                    <li>Details about your property (for cleaning service estimates)</li>
                    <li>Any information you choose to share through our contact form, phone, or email</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">2. How We Use Your Information</h3>
                <p class="text-base leading-relaxed mb-2">We use your information to:</p>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>Respond to your enquiries or provide quotes</li>
                    <li>Schedule and perform cleaning services</li>
                    <li>Send invoices, receipts, or service reminders</li>
                    <li>Improve our services and customer experience</li>
                </ul>
                <p class="text-base leading-relaxed mt-3">
                    We do not sell, rent, or share your information with third parties, except:
                </p>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700 mt-2">
                    <li>When required by law</li>
                    <li>To trusted service providers who assist us in running our business (e.g., accounting or website hosting), who must keep your information secure and confidential</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">3. Data Storage and Security</h3>
                <p class="text-base leading-relaxed">
                    We take reasonable steps to keep your personal information safe from unauthorised access, loss, or misuse. Information is stored securely and only accessible to authorised staff.
                </p>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">4. Cookies and Website Data</h3>
                <p class="text-base leading-relaxed">
                    Our website may use basic cookies to improve browsing experience and website functionality. You can disable cookies through your browser settings if preferred.
                </p>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">5. Access and Correction</h3>
                <p class="text-base leading-relaxed mb-2">
                    You may request access to, or correction of, your personal information at any time by contacting us at:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 ml-4">
                    <p class="text-base"><strong>Email:</strong> <a href="mailto:Admin@iocleaningexperts.com.au" class="text-blue-600 hover:underline">Admin@iocleaningexperts.com.au</a></p>
                    <p class="text-base"><strong>Phone:</strong> <a href="tel:0431491143" class="text-blue-600 hover:underline">0431 491 143</a></p>
                </div>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">6. Updates to This Policy</h3>
                <p class="text-base leading-relaxed">
                    We may update this Privacy Policy from time to time. Any changes will be posted on this page with a new effective date.
                </p>
            </section>
        </div>
    `;

    const termsContent = `
        <div class="space-y-6">
            <p class="text-sm text-gray-600 italic">Effective Date: December 5, 2024</p>
            
            <p class="text-base leading-relaxed">
                By using our website or booking a cleaning service with In & Out Cleaning Experts, you agree to the following terms and conditions.
            </p>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">1. Services</h3>
                <p class="text-base leading-relaxed">
                    We provide residential and commercial cleaning services across South Australia. All services are performed professionally, safely, and with reasonable care and skill.
                </p>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">2. Quotes and Pricing</h3>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>Our website includes an <strong>estimator (cleaning calculator)</strong> designed to give customers an <strong>approximate cost overview</strong> based on the information entered.</li>
                    <li>Please note that this tool provides an <strong>estimate only</strong>. It does <strong>not</strong> represent a final or binding quotation.</li>
                    <li>The <strong>final quotation</strong> will be provided <strong>after an on-site inspection</strong> or detailed review of the cleaning area to confirm size, condition, and specific requirements.</li>
                    <li>All quotes are based on accurate information provided by the client.</li>
                    <li>If the actual conditions or scope differ from the information supplied, pricing may be adjusted accordingly.</li>
                    <li>Any changes will always be discussed and agreed upon before work begins.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">3. Cancellations and Rescheduling</h3>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>Please provide at least <strong>24 hours' notice</strong> to cancel or reschedule a booking.</li>
                    <li>Cancellations made within 24 hours of the scheduled service may incur a small fee to cover lost time and travel.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">4. Payments</h3>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>Payment is due on completion of the service unless otherwise agreed in writing.</li>
                    <li>We accept cash, bank transfer, and other payment methods.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">5. Customer Responsibilities</h3>
                <p class="text-base leading-relaxed mb-2">To ensure a smooth cleaning process, please:</p>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>Provide access to the property at the agreed time</li>
                    <li>Secure or remove valuables or fragile items if necessary</li>
                    <li>Notify us of any special cleaning requirements or areas of concern</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">6. Damage or Breakage</h3>
                <p class="text-base leading-relaxed">
                    We take great care while cleaning. In the rare event of accidental damage, we will notify you immediately and aim to resolve the matter fairly.
                </p>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">7. Satisfaction Guarantee</h3>
                <p class="text-base leading-relaxed">
                    If you are not satisfied with our cleaning service, please contact us within <strong>24 hours</strong> and we will make reasonable efforts to address the issue.
                </p>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">8. Limitation of Liability</h3>
                <p class="text-base leading-relaxed">
                    To the maximum extent permitted by law, In & Out Cleaning Experts shall not be liable for any indirect, incidental, or consequential damages resulting from the use of our services.
                </p>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">9. Website Use</h3>
                <ul class="list-disc list-inside text-base space-y-2 ml-4 text-gray-700">
                    <li>The content on our website is for general information only.</li>
                    <li>You may not copy, modify, or reproduce any text, images, or materials without prior written permission.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-xl font-bold mb-3 text-[#3c5170]">10. Contact Us</h3>
                <p class="text-base leading-relaxed mb-2">For questions about these terms or our services, please contact:</p>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 ml-4">
                    <p class="text-base"><strong>Email:</strong> <a href="mailto:Admin@iocleaningexperts.com.au" class="text-blue-600 hover:underline">Admin@iocleaningexperts.com.au</a></p>
                    <p class="text-base"><strong>Phone:</strong> <a href="tel:0431491143" class="text-blue-600 hover:underline">0431 491 143</a></p>
                    <p class="text-base"><strong>Location:</strong> Adelaide, South Australia</p>
                </div>
            </section>
        </div>
    `;

    function openModal(type) {
        const modal = document.getElementById('policyModal');
        const backdrop = document.getElementById('policyBackdrop');
        const content = document.getElementById('policyModalContent');
        const title = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');

        // Set content based on type
        if (type === 'privacy') {
            title.textContent = 'Privacy Policy';
            modalContent.innerHTML = privacyContent;
        } else if (type === 'terms') {
            title.textContent = 'Terms and Conditions';
            modalContent.innerHTML = termsContent;
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            backdrop.classList.remove('bg-opacity-0');
            backdrop.classList.add('bg-opacity-50');
            content.classList.remove('translate-y-[-100vh]', 'opacity-0');
            content.classList.add('translate-y-0', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('policyModal');
        const backdrop = document.getElementById('policyBackdrop');
        const content = document.getElementById('policyModalContent');

        backdrop.classList.remove('bg-opacity-50');
        backdrop.classList.add('bg-opacity-0');
        content.classList.remove('translate-y-0', 'opacity-100');
        content.classList.add('translate-y-[-100vh]', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 500);
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>

<script src="../js/navbar.js"></script>
<script src="../js/cursor.js"></script>
<script src="../js/service.js"></script>
<script src="https://cdn.lordicon.com/lordicon.js"></script>