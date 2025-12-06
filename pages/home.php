<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>
<?php include "backend/select-homepage.php" ?>
<section class="relative overflow-hidden hero-section min-h-screen flex flex-col">
    <div class="py-8 px-4 md:px-[10%] flex flex-col font-main relative z-10">
        <!-- Main Hero Section -->
        <div
            class="w-full flex lg:flex-row flex-col-reverse items-center justify-center md:bg-white/80 rounded-[40px] px-4 md:px-8 py-8 gap-6">

            <!-- Left Content Section -->

            <div class="w-full lg:w-1/2 flex flex-col justify-center">
                <div class="px-6 md:px-10 flex flex-col md:bg-white/10 bg-white/80 rounded-xl  justify-between">
                    <div>
                        <h1
                            class="text-2xl md:text-4xl font-main mb-6 bg-gradient-to-r from-[#61442a] to-[#a0846d] bg-clip-text text-transparent leading-tight">
                            <?php echo isset($row['cta']) && !empty($row['cta']) ? htmlspecialchars($row['cta']) : ''; ?>
                        </h1>

                        <span
                            class="text-base md:text-xl font-semibold text-[#37271a] font-secondary text-justify leading-relaxed">
                            <?php echo isset($row['support_headline']) && !empty($row['support_headline']) ? htmlspecialchars($row['support_headline']) : ''; ?>
                        </span>
                    </div>

                    <a href="services.php"
                        class="text-white flex items-center  justify-center w-full py-3 px-10 md:bg-[#3c5170] bg-[#c79a73] rounded-xl hover:bg-gradient-to-r from-[#b28b6c] via-[#f4c49a] to-[#a48160] transition-all duration-300 ease-in-out hover:text-[#3c5170] hover:cursor-pointer font-semibold mt-8">
                        <?php echo isset($row['button_cta']) && !empty($row['button_cta']) ? htmlspecialchars($row['button_cta']) : ''; ?>
                    </a>
                </div>
            </div>


            <!-- Right Image Section -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center">
                <img src="../admin/backend/<?php echo htmlspecialchars($row['image']); ?>" alt=""
                    class="w-full h-auto rounded-xl relative z-10 shadow-lg">
            </div>
        </div>
    </div>

    <!-- Feature Box Section -->
    <div class="w-full flex items-center justify-center py-10 px-4">
        <div
            class="w-[90%] md:w-[80%] bg-gradient-to-r from-[#b28b6c] via-[#f4c49a] to-[#a48160] rounded-xl p-6 md:p-8">
            <div class="flex flex-wrap lg:flex-nowrap gap-4 md:gap-6 justify-center items-stretch">

                <!-- Feature 1 -->
                <div
                    class="flex flex-col flex-1 bg-white rounded-xl shadow-md items-center justify-center text-center p-6 min-h-[220px] transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <lord-icon src="https://cdn.lordicon.com/vttzorhw.json" trigger="loop" delay="2000"
                        colors="primary:#3c5170,secondary:#c3956f" style="width:80px;height:80px">
                    </lord-icon>
                    <span class="text-base md:text-lg font-semibold text-[#3c5170] mt-4 leading-snug">
                        <?php echo isset($row['card1']) && !empty($row['card1']) ? htmlspecialchars($row['card1']) : ''; ?>
                    </span>
                </div>

                <!-- Feature 2 -->
                <div
                    class="flex flex-col flex-1 bg-white rounded-xl shadow-md items-center justify-center text-center p-6 min-h-[220px] transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <lord-icon src="https://cdn.lordicon.com/onmwuuox.json" trigger="loop" delay="2000"
                        colors="primary:#3c5170,secondary:#c3956f" style="width:80px;height:80px">
                    </lord-icon>
                    <span class="text-base md:text-lg font-semibold text-[#3c5170] mt-4 leading-snug">
                        <?php echo isset($row['card2']) && !empty($row['card2']) ? htmlspecialchars($row['card2']) : ''; ?>
                    </span>
                </div>

                <!-- Feature 3 -->
                <div
                    class="flex flex-col flex-1 bg-white rounded-xl shadow-md items-center justify-center text-center p-6 min-h-[220px] transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <lord-icon src="https://cdn.lordicon.com/twnqgmao.json" trigger="loop" delay="2000"
                        colors="primary:#3c5170,secondary:#c3956f" style="width:80px;height:80px">
                    </lord-icon>
                    <span class="text-base md:text-lg font-semibold text-[#3c5170] mt-4 leading-snug">
                        <?php echo isset($row['card3']) && !empty($row['card3']) ? htmlspecialchars($row['card3']) : ''; ?>
                    </span>
                </div>

                <!-- Feature 4 -->
                <div
                    class="flex flex-col flex-1 bg-white rounded-xl shadow-md items-center justify-center text-center p-6 min-h-[220px] transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <div class=" flex items-center justify-center mb-2">
                        <img src="../images/dollar.gif" class="w-[130px] -mt-5" alt="">
                    </div>
                    <span class="text-base md:text-lg font-semibold text-[#3c5170] -mt-6 leading-snug">
                        <?php echo isset($row['card4']) && !empty($row['card4']) ? htmlspecialchars($row['card4']) : ''; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php" ?>
</section>