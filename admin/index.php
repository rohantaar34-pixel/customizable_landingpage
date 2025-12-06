<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<!-- Success Modal -->
<div id="successModal"
    class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex justify-center items-center z-50 font-main">
    <div class="bg-white rounded-2xl shadow-2xl p-10 w-[90%] max-w-md border border-gray-200 relative overflow-hidden">
        <!-- Decorative corner elements -->
        <div class="absolute top-0 left-0 w-20 h-20 border-t-2 border-l-2 border-black opacity-10"></div>
        <div class="absolute bottom-0 right-0 w-20 h-20 border-b-2 border-r-2 border-black opacity-10"></div>

        <div class="text-center relative z-10">
            <div class="mx-auto w-20 h-20 bg-black rounded-full flex items-center justify-center mb-6 shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-bold text-black mb-3 tracking-tight">Login Successful</h3>
            <p class="text-gray-500 mb-8 text-lg">Welcome back! Redirecting to your dashboard...</p>
            <button onclick="closeModal()"
                class="bg-black text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-all duration-300 border-2 border-black hover:shadow-lg">
                Continue
            </button>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex justify-center items-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-10 w-[90%] max-w-md border border-gray-200 relative overflow-hidden">
        <!-- Decorative corner elements -->
        <div class="absolute top-0 left-0 w-20 h-20 border-t-2 border-l-2 border-black opacity-10"></div>
        <div class="absolute bottom-0 right-0 w-20 h-20 border-b-2 border-r-2 border-black opacity-10"></div>

        <div class="text-center relative z-10">
            <div
                class="mx-auto w-20 h-20 bg-white border-4 border-black rounded-full flex items-center justify-center mb-6 shadow-lg">
                <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>
            <h3 class="text-3xl font-bold text-black mb-3 tracking-tight">Authentication Failed</h3>
            <p id="errorMessage" class="text-gray-500 mb-8 text-lg"></p>
            <button onclick="closeModal()"
                class="bg-white text-black px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all duration-300 border-2 border-black hover:shadow-lg">
                Try Again
            </button>
        </div>
    </div>
</div>

<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex justify-center items-center py-12 px-4">
    <div
        class="w-full max-w-xl bg-white border-2 border-black rounded-2xl shadow-2xl px-12 py-14 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-black opacity-5 rounded-bl-full"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-black opacity-5 rounded-tr-full"></div>

        <!-- Corner accents -->
        <div class="absolute top-4 left-4 w-12 h-12 border-t-2 border-l-2 border-black"></div>
        <div class="absolute bottom-4 right-4 w-12 h-12 border-b-2 border-r-2 border-black"></div>

        <div class="text-center mb-10 relative z-10">
            <div class="inline-block mb-4">
                <div class="w-16 h-1 bg-black mx-auto"></div>
            </div>
            <h1 class="text-5xl font-bold text-black mb-3 tracking-tight">Welcome Back</h1>
            <p class="text-gray-500 text-lg">Sign in to continue your journey</p>
        </div>

        <form id="loginForm" class="space-y-7 relative z-10">
            <!-- Email Input -->
            <div class="relative">
                <label class="block text-xs font-bold text-black mb-3 tracking-widest uppercase">Username</label>
                <input type="text" id="user" name="user" placeholder="Enter your username" required
                    class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-black transition-all duration-300 bg-white hover:border-gray-400 text-lg">
                <div
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-black transition-all duration-300 group-focus-within:w-full">
                </div>
            </div>

            <!-- Password Input with Show/Hide -->
            <div class="relative">
                <label class="block text-xs font-bold text-black mb-3 tracking-widest uppercase">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required
                        class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-black transition-all duration-300 bg-white hover:border-gray-400 pr-14 text-lg">
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors duration-300">
                        <svg id="eyeOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        <svg id="eyeClosed" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" id="loginBtn"
                    class="w-full bg-black text-white py-5 rounded-xl font-bold hover:bg-gray-900 transition-all duration-300 text-lg tracking-wide border-2 border-black hover:shadow-2xl transform hover:-translate-y-0.5 relative overflow-hidden group">
                    <span class="relative z-10">Sign In</span>
                    <div
                        class="absolute inset-0 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left opacity-10">
                    </div>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center relative z-10">
            <div class="inline-block">
                <div class="w-12 h-0.5 bg-gray-300 mx-auto"></div>
            </div>
        </div>
    </div>
</section>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }

    function closeModal() {
        document.getElementById('successModal').classList.add('hidden');
        document.getElementById('errorModal').classList.add('hidden');
    }

    // AJAX Login
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const email = document.getElementById('user').value;
        const password = document.getElementById('password').value;
        const loginBtn = document.getElementById('loginBtn');

        // Disable button during request
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<span class="relative z-10">Signing In...</span>';

        // Create FormData
        const formData = new FormData();
        formData.append('user', email);
        formData.append('password', password);

        // AJAX Request
        fetch('backend/login.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<span class="relative z-10">Sign In</span>';

                if (data.success) {
                    // Show success modal
                    document.getElementById('successModal').classList.remove('hidden');

                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = data.redirect || 'dashboard.php';
                    }, 2000);
                } else {
                    // Show error modal
                    document.getElementById('errorMessage').textContent = data.message;
                    document.getElementById('errorModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<span class="relative z-10">Sign In</span>';
                document.getElementById('errorMessage').textContent = 'Connection error. Please try again.';
                document.getElementById('errorModal').classList.remove('hidden');
            });
    });
</script>

<?php include "includes/footer.php" ?>