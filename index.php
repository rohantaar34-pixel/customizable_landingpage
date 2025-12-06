<?php include "includes/header.php" ?>

<div id="loadingScreen"
    class="min-h-screen py-2 px-[10%] flex items-center flex-col justify-center bg-white opacity-0 transition-opacity duration-500">
    <img src="images/logo.png" class="w-[400px] mb-8" alt="">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Loading...</h1>

    <!-- Progress Bar Container -->
    <div class="w-[400px] h-2 bg-gray-200 rounded-full overflow-hidden">
        <div id="progressBar" class="h-full bg-blue-600 rounded-full transition-all duration-100" style="width: 0%">
        </div>
    </div>

    <p id="progressText" class="mt-4 text-gray-600 text-sm">0%</p>
</div>

<script>
    // Fade in the loading screen
    window.addEventListener('load', function () {
        const loadingScreen = document.getElementById('loadingScreen');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        // Fade in
        loadingScreen.style.opacity = '1';

        // Progress animation
        let progress = 0;
        const duration = 3000; // 3 seconds
        const interval = 30; // Update every 30ms
        const increment = (interval / duration) * 100;

        const progressInterval = setInterval(function () {
            progress += increment;

            if (progress >= 100) {
                progress = 100;
                clearInterval(progressInterval);

                // Fade out and redirect
                setTimeout(function () {
                    loadingScreen.style.opacity = '0';

                    // Redirect after fade out completes
                    setTimeout(function () {
                        window.location.href = 'pages/home.php';
                    }, 500); // Wait for fade out animation
                }, 100);
            }

            progressBar.style.width = progress + '%';
            progressText.textContent = Math.floor(progress) + '%';
        }, interval);
    });
</script>

<?php include "includes/footer.php" ?>