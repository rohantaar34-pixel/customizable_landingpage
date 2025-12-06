<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>
<?php include "backend/select-aboutpage.php" ?>
<section class="relative overflow-hidden hero-section min-h-screen flex flex-col">
    <div class="py-5 px-4 md:px-[10%] flex flex-col font-main relative z-10 items-center justify-around">
        <div class="md:w-[90%] w-[95%] flex flex-col md:flex-row bg-white rounded-xl px-6 py-8 shadow-lg">
            <!-- Left Side: About Us Text -->
            <div class="md:w-1/2 w-full pr-0 md:pr-8 mb-6 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-bold text-primary  border-black border-b-2 text-[#37271a]">
                    About Us</h1>
                <div class="text-lg  text-[#37271a] whitespace-pre-line -mt-6 text-justify">
                    <?php echo isset($row['about']) && !empty($row['about']) ? htmlspecialchars($row['about']) : ''; ?>
                </div>
            </div>
            <!-- Right Side: Company Image Gallery -->
            <div class="md:w-1/2 w-full">
                <div class="grid grid-cols-1 gap-4">
                    <img src="../images/pic1.png" alt="Company Image 1"
                        class="w-full h-32 md:h-70 object-cover rounded-lg shadow-md">
                    <img src="../images/pic2.png" alt="Company Image 2"
                        class="w-full h-32 md:h-70 object-cover rounded-lg shadow-md">
                    <img src="../images/pic3.png" alt="Company Image 3"
                        class="w-full h-32 md:h-70 object-cover rounded-lg shadow-md">
                    <img src="../images/pic4.png" alt="Company Image 4"
                        class="w-full h-32 md:h-70 object-cover rounded-lg shadow-md">
                </div>
            </div>
        </div>


    </div>
</section>
<?php include "includes/footer.php" ?>