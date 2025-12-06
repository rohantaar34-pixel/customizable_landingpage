<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>


<section class="min-h-screen bg-white flex justify-center items-start py-5 py-5 p-[10%]">
    <div class="flex flex-col">
        <h1 class="text-3xl">Welcome to editing section Mr Jerwin Butuhan!</h1>
        <h1>Here you can edit 80% of your content! just follow and read the label correctly and you can modify your
            system
            freely!</h1>
        <hr>
        <h1 class="mb-4">Please Select The page you want to edit.</h1>
        <div class="w-full grid md:grid-cols-4  grid-cols-1 gap-2 flex-row">
            <a href="home.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-regular fa-house"></i>
                    <h1>Home Page</h1>
                </div>
            </a>
            <a href="about.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-solid fa-user-tie"></i>
                    <h1>About Page</h1>
                </div>
            </a>
            <a href="reviews.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-solid fa-comment"></i>
                    <h1>Testimonial Page</h1>
                </div>
            </a>
            <a href="services.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-solid fa-bell-concierge"></i>
                    <h1>Service Page</h1>
                </div>
            </a>
            <a href="navbar.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-solid fa-heading"></i>
                    <h1>Header Part</h1>
                </div>
            </a>
            <a href="footer.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-solid fa-shoe-prints"></i>
                    <h1>Footer Part</h1>
                </div>
            </a>
            <a href="analytics.php">
                <div
                    class="w-full h-[120px] bg-[#3c5170] hover:text-[] text-white rounded-xl flex items-center justify-center flex-col">
                    <i class="fa-solid fa-shoe-prints"></i>
                    <h1>Analytics</h1>
                </div>
            </a>
        </div>
    </div>

</section>

<?php include "includes/footer.php" ?>