<?php
include "includes/config.php";
$conn = conn();

// Fetch active testimonials
$testimonials_query = mysqli_query($conn, "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY created_at DESC");
$testimonials = [];
while ($row = mysqli_fetch_assoc($testimonials_query)) {
    $testimonials[] = $row;
}
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<section class="relative overflow-hidden hero-section min-h-screen flex flex-col py-10 px-4 md:px-[8%] font-main">
    <div class="flex flex-col lg:flex-row gap-10 bg-white rounded-3xl shadow-md p-6 md:p-10 z-50 w-full">

        <!-- ✨ Testimonials & Before-After Section -->
        <div class="w-full flex flex-col gap-10">
            <!-- 🧹 Section Title -->
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">What Our Clients Say</h2>
                <p class="text-gray-500 mt-2">Real experiences from our satisfied customers</p>
            </div>

            <?php if (count($testimonials) > 0): ?>
                <!-- 💬 Draggable Testimonials Container -->
                <div class="relative">
                    <div class="testimonial-container overflow-x-auto overflow-y-hidden py-4 cursor-grab active:cursor-grabbing"
                        id="testimonialContainer">
                        <div class="testimonial-track flex gap-6" id="testimonialTrack">
                            <?php foreach ($testimonials as $index => $testimonial): ?>
                                <div class="testimonial-card flex-shrink-0 w-80 bg-gray-50 rounded-2xl shadow-md transition-shadow cursor-pointer select-none"
                                    onclick='openModal(<?php echo json_encode($testimonial, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>
                                    <div class="relative overflow-hidden rounded-t-2xl">
                                        <div class="grid grid-cols-2">
                                            <?php if ($testimonial['before_image']): ?>
                                                <img src="../admin/<?php echo htmlspecialchars($testimonial['before_image']); ?>"
                                                    alt="Before" class="object-cover w-full h-32 grayscale pointer-events-none"
                                                    loading="lazy" draggable="false">
                                            <?php else: ?>
                                                <div class="bg-gray-300 w-full h-32 flex items-center justify-center">
                                                    <span class="text-gray-500 text-sm">No Image</span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($testimonial['after_image']): ?>
                                                <img src="../admin/<?php echo htmlspecialchars($testimonial['after_image']); ?>"
                                                    alt="After" class="object-cover w-full h-32 pointer-events-none" loading="lazy"
                                                    draggable="false">
                                            <?php else: ?>
                                                <div class="bg-gray-300 w-full h-32 flex items-center justify-center">
                                                    <span class="text-gray-500 text-sm">No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div
                                            class="absolute bottom-0 w-full bg-black/70 text-white text-xs p-1.5 flex justify-between">
                                            <span>Before</span>
                                            <span>After</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <p class="text-gray-600 italic text-sm mb-3 line-clamp-3">
                                            "<?php echo htmlspecialchars(substr($testimonial['feedback'], 0, 100)) . (strlen($testimonial['feedback']) > 100 ? '...' : ''); ?>"
                                        </p>
                                        <div class="flex items-center gap-3">
                                            <?php if ($testimonial['avatar']): ?>
                                                <img src="../admin/<?php echo htmlspecialchars($testimonial['avatar']); ?>"
                                                    alt="Client" class="w-10 h-10 rounded-full object-cover pointer-events-none"
                                                    loading="lazy" draggable="false">
                                            <?php else: ?>
                                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fa-solid fa-user text-gray-500"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <h4 class="font-semibold text-gray-800 text-sm">
                                                    <?php echo htmlspecialchars($testimonial['client_name']); ?>
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    <?php echo htmlspecialchars($testimonial['service_type']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Drag Hint -->
                    <div class="text-center mt-4 text-gray-400 text-sm">
                        <i class="fa-solid fa-hand-pointer mr-2"></i>
                        Click and drag to scroll through testimonials
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-20">
                    <i class="fa-solid fa-comments text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl text-gray-500">No testimonials available yet</h3>
                    <p class="text-gray-400 mt-2">Check back soon for customer reviews!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="testimonialModal"
    class="fixed inset-0 bg-black/70 z-[9999] hidden items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div
        class="modal-content bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300">
        <!-- Close Button -->
        <button onclick="closeModal()"
            class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Modal Content -->
        <div id="modalContent" class="p-8">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<style>
    .testimonial-container {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    .testimonial-container::-webkit-scrollbar {
        height: 8px;
    }

    .testimonial-container::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 10px;
    }

    .testimonial-container::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    .testimonial-container::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    .testimonial-card:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #testimonialModal.show {
        display: flex !important;
        opacity: 1;
    }

    #testimonialModal.show .modal-content {
        transform: scale(1);
    }

    .testimonial-card,
    .modal-content {
        transform: translateZ(0);
        backface-visibility: hidden;
    }
</style>

<script>
    // Draggable functionality
    const container = document.getElementById('testimonialContainer');
    let isDown = false;
    let startX;
    let scrollLeft;
    let clickStartX;
    let hasDragged = false;
    let autoSlideInterval;
    let isUserInteracting = false;

    // Auto-slide configuration
    const SLIDE_INTERVAL = 3000; // 3 seconds between slides
    const SCROLL_SPEED = 1; // pixels per frame for smooth scrolling
    let targetScroll = 0;
    let currentScroll = 0;
    let isAnimating = false;

    // Smooth scrolling animation
    function smoothScroll() {
        if (!isAnimating) return;

        const diff = targetScroll - currentScroll;

        if (Math.abs(diff) < 0.5) {
            currentScroll = targetScroll;
            isAnimating = false;
            container.scrollLeft = currentScroll;
            return;
        }

        currentScroll += diff * 0.1; // Smooth easing
        container.scrollLeft = currentScroll;
        requestAnimationFrame(smoothScroll);
    }

    // Auto-slide function
    function autoSlide() {
        if (isUserInteracting) return;

        const cardWidth = 320 + 24; // card width (320px) + gap (24px)
        const maxScroll = container.scrollWidth - container.clientWidth;

        currentScroll = container.scrollLeft;
        targetScroll = currentScroll + cardWidth;

        // Reset to start if reached the end
        if (targetScroll >= maxScroll) {
            targetScroll = 0;
        }

        isAnimating = true;
        smoothScroll();
    }

    // Start auto-sliding
    function startAutoSlide() {
        stopAutoSlide(); // Clear any existing interval
        autoSlideInterval = setInterval(autoSlide, SLIDE_INTERVAL);
    }

    // Stop auto-sliding
    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }

    // Mouse events
    container.addEventListener('mousedown', (e) => {
        isDown = true;
        hasDragged = false;
        isUserInteracting = true;
        clickStartX = e.pageX;
        container.classList.add('active:cursor-grabbing');
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        stopAutoSlide();
    });

    container.addEventListener('mouseleave', () => {
        isDown = false;
        container.classList.remove('active:cursor-grabbing');
    });

    container.addEventListener('mouseup', () => {
        isDown = false;
        container.classList.remove('active:cursor-grabbing');

        // Resume auto-slide after user stops interacting
        setTimeout(() => {
            isUserInteracting = false;
            startAutoSlide();
        }, 2000); // Wait 2 seconds before resuming
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 2;
        container.scrollLeft = scrollLeft - walk;
        currentScroll = container.scrollLeft;

        // Check if user has dragged more than 5px
        if (Math.abs(e.pageX - clickStartX) > 5) {
            hasDragged = true;
        }
    });

    // Touch support for mobile
    container.addEventListener('touchstart', (e) => {
        isUserInteracting = true;
        startX = e.touches[0].pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        stopAutoSlide();
    });

    container.addEventListener('touchmove', (e) => {
        const x = e.touches[0].pageX - container.offsetLeft;
        const walk = (x - startX) * 2;
        container.scrollLeft = scrollLeft - walk;
        currentScroll = container.scrollLeft;
    });

    container.addEventListener('touchend', () => {
        // Resume auto-slide after user stops interacting
        setTimeout(() => {
            isUserInteracting = false;
            startAutoSlide();
        }, 2000);
    });

    // Pause auto-slide when hovering over container
    container.addEventListener('mouseenter', () => {
        isUserInteracting = true;
        stopAutoSlide();
    });

    container.addEventListener('mouseleave', () => {
        if (!isDown) {
            setTimeout(() => {
                isUserInteracting = false;
                startAutoSlide();
            }, 1000);
        }
    });

    // Modal functions
    function openModal(testimonial) {
        // Don't open modal if user was dragging
        if (hasDragged) {
            hasDragged = false;
            return;
        }

        const modal = document.getElementById('testimonialModal');
        const modalContent = document.getElementById('modalContent');

        const stars = '★'.repeat(testimonial.rating) + '☆'.repeat(5 - testimonial.rating);

        modalContent.innerHTML = `
            <div class="space-y-6">
                <!-- Before & After Images -->
                <div class="relative overflow-hidden rounded-3xl shadow-xl">
                    <div class="grid md:grid-cols-2 gap-2">
                        <div class="relative">
                            ${testimonial.before_image ?
                `<img src="../admin/${testimonial.before_image}" alt="Before" class="object-cover w-full h-80 " loading="lazy">` :
                `<div class="bg-gray-300 w-full h-80 flex items-center justify-center"><span class="text-gray-500 text-xl">No Before Image</span></div>`
            }
                            <div class="absolute top-4 left-4 bg-black/70 text-white px-4 py-2 rounded-lg font-semibold">
                                Before
                            </div>
                        </div>
                        <div class="relative">
                            ${testimonial.after_image ?
                `<img src="../admin/${testimonial.after_image}" alt="After" class="object-cover w-full h-80" loading="lazy">` :
                `<div class="bg-gray-300 w-full h-80 flex items-center justify-center"><span class="text-gray-500 text-xl">No After Image</span></div>`
            }
                            <div class="absolute top-4 left-4 bg-green-600 text-white px-4 py-2 rounded-lg font-semibold">
                                After
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Content -->
                <div class="bg-gray-50 p-8 rounded-3xl">
                    <div class="flex items-start gap-4 mb-6">
                        ${testimonial.avatar ?
                `<img src="../admin/${testimonial.avatar}" alt="${testimonial.client_name}" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg" loading="lazy">` :
                `<div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white shadow-lg"><i class="fa-solid fa-user text-gray-500 text-2xl"></i></div>`
            }
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">${testimonial.client_name}</h3>
                            <p class="text-gray-500">${testimonial.service_type}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex gap-1 text-yellow-400 text-2xl">
                            ${stars}
                        </div>
                        <p class="text-gray-700 text-lg leading-relaxed italic">
                            "${testimonial.feedback}"
                        </p>
                    </div>
                </div>
            </div>
        `;

        requestAnimationFrame(() => {
            modal.classList.add('show');
        });

        // Stop auto-slide when modal is open
        stopAutoSlide();
    }

    function closeModal() {
        const modal = document.getElementById('testimonialModal');
        modal.classList.remove('show');

        // Resume auto-slide after closing modal
        setTimeout(() => {
            startAutoSlide();
        }, 1000);
    }

    // Close modal when clicking outside
    document.getElementById('testimonialModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Initialize auto-slide when page loads
    window.addEventListener('load', () => {
        startAutoSlide();
    });
</script>

<?php include "includes/footer.php" ?>