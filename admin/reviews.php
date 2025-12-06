<?php
include "includes/config.php";
$conn = conn();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Add new testimonial
    if (isset($_POST['add_testimonial'])) {
        $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
        $service_type = mysqli_real_escape_string($conn, $_POST['service_type']);
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
        $rating = (int) $_POST['rating'];

        // Handle avatar image upload
        $avatar = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $upload_dir = 'uploads/testimonials/';
            if (!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);

            $avatar_ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $avatar_filename = 'avatar_' . time() . '_' . uniqid() . '.' . $avatar_ext;
            $avatar_path = $upload_dir . $avatar_filename;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
                $avatar = $avatar_path;
            }
        }

        // Handle before image upload
        $before_image = null;
        if (isset($_FILES['before_image']) && $_FILES['before_image']['error'] === 0) {
            $upload_dir = 'uploads/testimonials/';
            if (!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);

            $before_ext = pathinfo($_FILES['before_image']['name'], PATHINFO_EXTENSION);
            $before_filename = 'before_' . time() . '_' . uniqid() . '.' . $before_ext;
            $before_path = $upload_dir . $before_filename;

            if (move_uploaded_file($_FILES['before_image']['tmp_name'], $before_path)) {
                $before_image = $before_path;
            }
        }

        // Handle after image upload
        $after_image = null;
        if (isset($_FILES['after_image']) && $_FILES['after_image']['error'] === 0) {
            $upload_dir = 'uploads/testimonials/';
            if (!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);

            $after_ext = pathinfo($_FILES['after_image']['name'], PATHINFO_EXTENSION);
            $after_filename = 'after_' . time() . '_' . uniqid() . '.' . $after_ext;
            $after_path = $upload_dir . $after_filename;

            if (move_uploaded_file($_FILES['after_image']['tmp_name'], $after_path)) {
                $after_image = $after_path;
            }
        }

        $query = "INSERT INTO testimonials (client_name, service_type, feedback, avatar, before_image, after_image, rating, is_active) 
                  VALUES ('$client_name', '$service_type', '$feedback', '$avatar', '$before_image', '$after_image', $rating, 1)";

        if (mysqli_query($conn, $query)) {
            $success_msg = "Testimonial added successfully!";
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    }

    // Update testimonial
    if (isset($_POST['update_testimonial'])) {
        $id = (int) $_POST['testimonial_id'];
        $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
        $service_type = mysqli_real_escape_string($conn, $_POST['service_type']);
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
        $rating = (int) $_POST['rating'];

        // Get existing images
        $existing = mysqli_fetch_assoc(mysqli_query($conn, "SELECT avatar, before_image, after_image FROM testimonials WHERE id = $id"));
        $avatar = $existing['avatar'];
        $before_image = $existing['before_image'];
        $after_image = $existing['after_image'];

        // Handle avatar image upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $upload_dir = 'uploads/testimonials/';
            if (!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);

            $avatar_ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $avatar_filename = 'avatar_' . time() . '_' . uniqid() . '.' . $avatar_ext;
            $avatar_path = $upload_dir . $avatar_filename;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
                // Delete old avatar
                if ($avatar && file_exists($avatar))
                    unlink($avatar);
                $avatar = $avatar_path;
            }
        }

        // Handle before image upload
        if (isset($_FILES['before_image']) && $_FILES['before_image']['error'] === 0) {
            $upload_dir = 'uploads/testimonials/';
            if (!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);

            $before_ext = pathinfo($_FILES['before_image']['name'], PATHINFO_EXTENSION);
            $before_filename = 'before_' . time() . '_' . uniqid() . '.' . $before_ext;
            $before_path = $upload_dir . $before_filename;

            if (move_uploaded_file($_FILES['before_image']['tmp_name'], $before_path)) {
                // Delete old image
                if ($before_image && file_exists($before_image))
                    unlink($before_image);
                $before_image = $before_path;
            }
        }

        // Handle after image upload
        if (isset($_FILES['after_image']) && $_FILES['after_image']['error'] === 0) {
            $upload_dir = 'uploads/testimonials/';
            if (!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);

            $after_ext = pathinfo($_FILES['after_image']['name'], PATHINFO_EXTENSION);
            $after_filename = 'after_' . time() . '_' . uniqid() . '.' . $after_ext;
            $after_path = $upload_dir . $after_filename;

            if (move_uploaded_file($_FILES['after_image']['tmp_name'], $after_path)) {
                // Delete old image
                if ($after_image && file_exists($after_image))
                    unlink($after_image);
                $after_image = $after_path;
            }
        }

        $query = "UPDATE testimonials SET 
                  client_name = '$client_name',
                  service_type = '$service_type',
                  feedback = '$feedback',
                  avatar = '$avatar',
                  before_image = '$before_image',
                  after_image = '$after_image',
                  rating = $rating
                  WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            $success_msg = "Testimonial updated successfully!";
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    }

    // Toggle active status
    if (isset($_POST['toggle_active'])) {
        $id = (int) $_POST['testimonial_id'];
        $current_status = (int) $_POST['current_status'];
        $new_status = $current_status === 1 ? 0 : 1;

        mysqli_query($conn, "UPDATE testimonials SET is_active = $new_status WHERE id = $id");
        $success_msg = "Testimonial status updated!";
    }

    // Delete testimonial
    if (isset($_POST['delete_testimonial'])) {
        $id = (int) $_POST['testimonial_id'];

        // Get images to delete
        $result = mysqli_query($conn, "SELECT avatar, before_image, after_image FROM testimonials WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        // Delete images
        if ($row['avatar'] && file_exists($row['avatar']))
            unlink($row['avatar']);
        if ($row['before_image'] && file_exists($row['before_image']))
            unlink($row['before_image']);
        if ($row['after_image'] && file_exists($row['after_image']))
            unlink($row['after_image']);

        // Delete record
        mysqli_query($conn, "DELETE FROM testimonials WHERE id = $id");
        $success_msg = "Testimonial deleted successfully!";
    }
}

// Fetch all testimonials
$testimonials_query = mysqli_query($conn, "SELECT * FROM testimonials ORDER BY created_at DESC");
$testimonials = [];
while ($row = mysqli_fetch_assoc($testimonials_query)) {
    $testimonials[] = $row;
}
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<section class="min-h-screen bg-white flex justify-center items-start py-5 p-[10%]">
    <div class="flex flex-col w-full">
        <a href="dashboard.php" class="bg-[#f4c49a] text-[#3c5170] text-xl rounded p-2 w-fit">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>

        <h1 class="text-3xl font-bold mt-4">Testimonials Management</h1>
        <p class="text-gray-600 mb-4">Add, edit, or delete customer testimonials and reviews</p>
        <hr class="mb-6">

        <?php if (isset($success_msg)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_msg)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <!-- Add New Testimonial Form -->
        <div class="bg-gray-50 p-6 rounded-lg mb-8">
            <h2 class="text-2xl font-bold mb-4">Add New Testimonial</h2>
            <form method="POST" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Client Name *</label>
                    <input type="text" name="client_name" required class="border-2 p-2 rounded" placeholder="John Doe">
                </div>

                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Service Type *</label>
                    <input type="text" name="service_type" required class="border-2 p-2 rounded"
                        placeholder="House Cleaning">
                </div>

                <div class="flex flex-col md:col-span-2">
                    <label class="font-semibold mb-1">Feedback/Review *</label>
                    <textarea name="feedback" required rows="4" class="border-2 p-2 rounded"
                        placeholder="Share your experience..."></textarea>
                </div>

                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Avatar Image</label>
                    <input type="file" name="avatar" accept="image/*" class="border-2 p-2 rounded">
                    <small class="text-gray-500">Leave blank for default avatar</small>
                </div>

                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Rating *</label>
                    <select name="rating" required class="border-2 p-2 rounded">
                        <option value="5">5 Stars ★★★★★</option>
                        <option value="4">4 Stars ★★★★☆</option>
                        <option value="3">3 Stars ★★★☆☆</option>
                        <option value="2">2 Stars ★★☆☆☆</option>
                        <option value="1">1 Star ★☆☆☆☆</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Before Image</label>
                    <input type="file" name="before_image" accept="image/*" class="border-2 p-2 rounded">
                </div>

                <div class="flex flex-col">
                    <label class="font-semibold mb-1">After Image</label>
                    <input type="file" name="after_image" accept="image/*" class="border-2 p-2 rounded">
                </div>

                <div class="md:col-span-2">
                    <button type="submit" name="add_testimonial"
                        class="bg-[#3c5170] text-white px-6 py-3 rounded hover:bg-[#2a3a50] transition">
                        <i class="fa-solid fa-plus mr-2"></i>Add Testimonial
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Testimonials -->
        <h2 class="text-2xl font-bold mb-4">Existing Testimonials (<?php echo count($testimonials); ?>)</h2>

        <div class="grid gap-6">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="border rounded-lg p-6 <?php echo $testimonial['is_active'] ? 'bg-white' : 'bg-gray-100'; ?>">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold"><?php echo htmlspecialchars($testimonial['client_name']); ?></h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($testimonial['service_type']); ?></p>
                            <div class="text-yellow-400 mt-1">
                                <?php echo str_repeat('★', $testimonial['rating']) . str_repeat('☆', 5 - $testimonial['rating']); ?>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span
                                class="px-3 py-1 rounded text-sm <?php echo $testimonial['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-300 text-gray-700'; ?>">
                                <?php echo $testimonial['is_active'] ? 'Active' : 'Hidden'; ?>
                            </span>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm font-semibold mb-1">Avatar</p>
                            <?php if ($testimonial['avatar']): ?>
                                <img src="<?php echo htmlspecialchars($testimonial['avatar']); ?>" alt="Avatar"
                                    class="w-20 h-20 rounded-full object-cover border-2">
                            <?php else: ?>
                                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center border-2">
                                    <i class="fa-solid fa-user text-gray-500"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <p class="text-sm font-semibold mb-1">Before Image</p>
                            <?php if ($testimonial['before_image']): ?>
                                <img src="<?php echo htmlspecialchars($testimonial['before_image']); ?>" alt="Before"
                                    class="w-full h-32 object-cover rounded grayscale">
                            <?php else: ?>
                                <div class="bg-gray-300 w-full h-32 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <p class="text-sm font-semibold mb-1">After Image</p>
                            <?php if ($testimonial['after_image']): ?>
                                <img src="<?php echo htmlspecialchars($testimonial['after_image']); ?>" alt="After"
                                    class="w-full h-32 object-cover rounded">
                            <?php else: ?>
                                <div class="bg-gray-300 w-full h-32 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <p class="text-gray-700 italic mb-4">"<?php echo htmlspecialchars($testimonial['feedback']); ?>"</p>

                    <details class="mb-4">
                        <summary class="cursor-pointer font-semibold text-[#3c5170] hover:underline">Edit Testimonial
                        </summary>
                        <form method="POST" enctype="multipart/form-data"
                            class="grid md:grid-cols-2 gap-4 mt-4 p-4 bg-gray-50 rounded">
                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">

                            <div class="flex flex-col">
                                <label class="font-semibold mb-1">Client Name</label>
                                <input type="text" name="client_name"
                                    value="<?php echo htmlspecialchars($testimonial['client_name']); ?>" required
                                    class="border-2 p-2 rounded">
                            </div>

                            <div class="flex flex-col">
                                <label class="font-semibold mb-1">Service Type</label>
                                <input type="text" name="service_type"
                                    value="<?php echo htmlspecialchars($testimonial['service_type']); ?>" required
                                    class="border-2 p-2 rounded">
                            </div>

                            <div class="flex flex-col md:col-span-2">
                                <label class="font-semibold mb-1">Feedback</label>
                                <textarea name="feedback" required rows="3"
                                    class="border-2 p-2 rounded"><?php echo htmlspecialchars($testimonial['feedback']); ?></textarea>
                            </div>

                            <div class="flex flex-col">
                                <label class="font-semibold mb-1">Avatar Image</label>
                                <input type="file" name="avatar" accept="image/*" class="border-2 p-2 rounded">
                                <small class="text-gray-500">Leave blank to keep current avatar</small>
                            </div>

                            <div class="flex flex-col">
                                <label class="font-semibold mb-1">Rating</label>
                                <select name="rating" required class="border-2 p-2 rounded">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <option value="<?php echo $i; ?>" <?php echo $testimonial['rating'] == $i ? 'selected' : ''; ?>>
                                            <?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <label class="font-semibold mb-1">Before Image</label>
                                <input type="file" name="before_image" accept="image/*" class="border-2 p-2 rounded">
                                <small class="text-gray-500">Leave blank to keep current image</small>
                            </div>

                            <div class="flex flex-col">
                                <label class="font-semibold mb-1">After Image</label>
                                <input type="file" name="after_image" accept="image/*" class="border-2 p-2 rounded">
                                <small class="text-gray-500">Leave blank to keep current image</small>
                            </div>

                            <div class="md:col-span-2">
                                <button type="submit" name="update_testimonial"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-save mr-2"></i>Update
                                </button>
                            </div>
                        </form>
                    </details>

                    <div class="flex gap-2">
                        <form method="POST" class="inline">
                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $testimonial['is_active']; ?>">
                            <button type="submit" name="toggle_active"
                                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                                <i class="fa-solid fa-eye<?php echo $testimonial['is_active'] ? '-slash' : ''; ?> mr-2"></i>
                                <?php echo $testimonial['is_active'] ? 'Hide' : 'Show'; ?>
                            </button>
                        </form>

                        <form method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                            <button type="submit" name="delete_testimonial"
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                <i class="fa-solid fa-trash mr-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include "includes/footer.php" ?>