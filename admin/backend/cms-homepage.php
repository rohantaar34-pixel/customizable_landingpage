<?php
//this is cms section of homepage
//you can see all the code regarding in changing values here in homepage
if (isset($_POST['cta'])) {
    $input = $_POST['cta_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET cta = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}


if (isset($_POST['Supporting_headline'])) {
    $input = $_POST['sh_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET support_headline = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}
if (isset($_POST['button_cta'])) {
    $input = $_POST['bt_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET button_cta = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}



if (isset($_POST['card1'])) {
    $input = $_POST['card1_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET card1 = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}

if (isset($_POST['card2'])) {
    $input = $_POST['card2_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET card2 = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}
if (isset($_POST['card3'])) {
    $input = $_POST['card3_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET card3 = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}
if (isset($_POST['card4'])) {
    $input = $_POST['card4_input'];
    $id = 1;
    $sql_insert1 = "UPDATE homepage SET card4 = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: home.php");

}




?>
<?php
// Image upload handler with database path insertion
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('MAX_UPLOAD_MB', 10);
define('TARGET_MB', 0.5);
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // Validate upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        exit("Upload error");
    }

    if ($file['size'] > MAX_UPLOAD_MB * 1024 * 1024) {
        exit("File too large");
    }

    $info = @getimagesize($file['tmp_name']);
    if (!$info || !in_array($info['mime'], ALLOWED_TYPES)) {
        exit("Invalid image");
    }

    // Create upload directory
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    // Generate unique filename
    $ext = image_type_to_extension($info[2]);
    $filename = bin2hex(random_bytes(8)) . $ext;
    $destPath = UPLOAD_DIR . $filename;
    $tmpPath = UPLOAD_DIR . 'tmp_' . $filename;

    // Move and compress
    if (!move_uploaded_file($file['tmp_name'], $tmpPath)) {
        exit("Upload failed");
    }

    $targetBytes = TARGET_MB * 1024 * 1024;
    $finalPath = compress_image($tmpPath, $destPath, $info['mime'], $targetBytes);
    @unlink($tmpPath);

    if ($finalPath) {
        // Insert image path into database
        $imagePath = 'uploads/' . $filename;
        $id = 1;
        $sql = "UPDATE homepage SET image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $imagePath, $id);
        $stmt->execute();

        header("location: home.php");
    } else {
        exit("Compression failed");
    }
}

// Compression function
function compress_image($src, $dest, $mime, $target)
{
    switch ($mime) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($src);
            $quality = 90;
            do {
                imagejpeg($img, $dest, $quality);
                clearstatcache(true, $dest);
                $quality -= 10;
            } while (filesize($dest) > $target && $quality >= 30);
            imagedestroy($img);
            return $dest;

        case 'image/png':
            $img = imagecreatefrompng($src);
            for ($level = 6; $level <= 9; $level++) {
                imagepng($img, $dest, $level);
                clearstatcache(true, $dest);
                if (filesize($dest) <= $target) {
                    imagedestroy($img);
                    return $dest;
                }
            }
            // Fallback to JPEG
            $quality = 90;
            do {
                imagejpeg($img, $dest, $quality);
                clearstatcache(true, $dest);
                $quality -= 10;
            } while (filesize($dest) > $target && $quality >= 30);
            imagedestroy($img);
            return $dest;

        case 'image/gif':
            $img = imagecreatefromgif($src);
            $quality = 90;
            do {
                imagejpeg($img, $dest, $quality);
                clearstatcache(true, $dest);
                $quality -= 10;
            } while (filesize($dest) > $target && $quality >= 30);
            imagedestroy($img);
            return $dest;
    }
    return false;
}
?>