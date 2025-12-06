<?php
// get-addons.php
header('Content-Type: application/json');

// Database configuration
$host = 'localhost';
$dbname = 'inandout';
$username = 'root';
$password = '';

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get service_id from query parameter
    $service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

    if ($service_id <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid service ID'
        ]);
        exit;
    }

    // Fetch add-ons for the service
    $sql = "SELECT id, adds_on, price FROM service_adds_on WHERE service_id = :service_id ORDER BY price ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':service_id' => $service_id]);

    $addons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'addons' => $addons
    ]);

} catch (PDOException $e) {
    error_log('Get Addons Error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Failed to load add-ons'
    ]);
}
?>