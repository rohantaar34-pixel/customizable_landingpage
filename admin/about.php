<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php include "includes/select-about-cms.php" ?>
<?php include "backend/cms-aboutpage.php" ?>

<section class="min-h-screen bg-white flex justify-center items-start py-5 py-5 p-[10%]">
    <div class="flex flex-col">
        <a href="dashboard.php" class="bg-[#f4c49a] text-[#3c5170] text-xl  rounded p-2">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
        <h1 class="text-3xl">Home Page Section</h1>
        <h1>Here you can edit 80% of your content! Just follow and read the label correctly, and you can modify your
            system freely!</h1>
        <hr>
        <h1 class="mb-4">Please select the page you want to edit.</h1>
        <h1 class="mb-4">Please Select The page you want to edit.</h1>
        <div class="w-full grid md:grid-cols-2  grid-cols-1 gap-2 flex-row">
            <form class="w-full flex flex-col" method="POST" action="#">
                <span>About Content</span>
                <textarea name="about_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['about']) && !empty($row['about']) ? htmlspecialchars($row['about']) : ''; ?></textarea>
                <button type="submit" name="about"
                    class="w-[20%] bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>

        </div>
    </div>

</section>

<?php include "includes/footer.php" ?>