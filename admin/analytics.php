<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php include "includes/select-about-cms.php" ?>
<?php include "backend/cms-aboutpage.php" ?>

<!-- Add SweetAlert2 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 md:px-[7%] ">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <a href="dashboard.php"
                class="inline-flex items-center gap-2 bg-[#f4c49a] hover:bg-[#e5b589] text-[#3c5170] font-semibold text-lg rounded-lg px-4 py-2 transition-all duration-200 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

</section>
<style>
    /* Smooth scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #3c5170;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #2d3e54;
    }

    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<?php include "includes/footer.php" ?>