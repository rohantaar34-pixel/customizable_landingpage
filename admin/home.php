<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php include "includes/select-homepage-cms.php" ?>
<?php include "backend/cms-homepage.php" ?>

<section class="min-h-screen bg-white flex justify-center items-start py-5 p-[10%]">

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
                <span>CTA</span>
                <textarea name="cta_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['cta']) && !empty($row['cta']) ? htmlspecialchars($row['cta']) : ''; ?></textarea>
                <button type="submit" name="cta" class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>

            <form class="w-full flex flex-col" method="POST" action="#">
                <span>Supporting headline</span>
                <textarea name="sh_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['support_headline']) && !empty($row['support_headline']) ? htmlspecialchars($row['support_headline']) : ''; ?></textarea>
                <button type="submit" name="Supporting_headline"
                    class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>

            <form class="w-full flex flex-col" method="POST" action="#">
                <span>Button CTA</span>
                <textarea name="bt_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['button_cta']) && !empty($row['button_cta']) ? htmlspecialchars($row['button_cta']) : ''; ?></textarea>
                <button type="submit" name="button_cta"
                    class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>

            <form class="w-full flex flex-col" method="POST" action="#">
                <span>Card 1 content</span>
                <textarea name="card1_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['card1']) && !empty($row['card1']) ? htmlspecialchars($row['card1']) : ''; ?></textarea>
                <button type="submit" name="card1" class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>

            <form class="w-full flex flex-col" method="POST" action="#">
                <span>Card 2 content</span>
                <textarea name="card2_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['card2']) && !empty($row['card2']) ? htmlspecialchars($row['card2']) : ''; ?></textarea>
                <button type="submit" name="card2" class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>
            <form class="w-full flex flex-col" method="POST" action="#">
                <span>Card 3 content</span>
                <textarea name="card3_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['card3']) && !empty($row['card3']) ? htmlspecialchars($row['card3']) : ''; ?></textarea>
                <button type="submit" name="card3" class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>
            <form class="w-full flex flex-col" method="POST" action="#">
                <span>Card 4 content</span>
                <textarea name="card4_input" id="" rows="10"
                    class="border-2 p-2"><?php echo isset($row['card4']) && !empty($row['card4']) ? htmlspecialchars($row['card4']) : ''; ?></textarea>
                <button type="submit" name="card4" class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Change</button>
            </form>
            <form class="w-full flex flex-col" method="POST" action="#" enctype="multipart/form-data">
                <span>Homepage Image</span>
                <div class="border-2 p-4 flex flex-col gap-2">
                    <?php if (isset($row['image']) && !empty($row['image'])): ?>
                        <div class="mb-2">
                            <img src="backend/<?php echo htmlspecialchars($row['image']); ?>" alt="Current homepage image"
                                class="max-w-xs h-auto border">
                            <p class="text-sm text-gray-600 mt-1">Current Image</p>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif" class="border p-2" required>
                    <p class="text-sm text-gray-600">Max file size: 10MB. Supported formats: JPEG, PNG, GIF</p>
                </div>
                <button type="submit" class="w-auto bg-[#3c5170] text-white px-2 py-2 mt-2">Upload Image</button>
            </form>
        </div>
    </div>

</section>

<?php include "includes/footer.php" ?>