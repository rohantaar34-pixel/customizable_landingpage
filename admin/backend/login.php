<?php
session_start();

include "../includes/config.php";
$conn = conn();

header("Content-Type: application/json");

$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';

// Check if fields are empty
if (empty($user) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill up all fields.',
    ]);
    exit();
}

// Query to get user data
$sql = "SELECT * FROM admin WHERE user = ?";
$prep = $conn->prepare($sql);
$prep->bind_param("s", $user); // "s" means string type
$prep->execute();
$result = $prep->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify the password against the hashed password in database
    if (password_verify($password, $row['password'])) {
        // Password is correct - set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['user'];
        $_SESSION['logged_in'] = true;

        echo json_encode([
            'success' => true,
            'message' => 'Login successful!',
            'redirect' => 'dashboard.php'
        ]);
    } else {
        // Password is incorrect
        echo json_encode([
            'success' => false,
            'message' => 'Login Failed. Please check your Username and Password.',
        ]);
    }
} else {
    // User not found
    echo json_encode([
        'success' => false,
        'message' => 'Login Failed. Please check your Username and Password.',
    ]);
}

$prep->close();
$conn->close();
?>