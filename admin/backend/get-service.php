<?php
// get-service.php

include "../includes/config.php";

header('Content-Type: application/json');

$conn = conn();

try {
    if (!isset($_GET['id'])) {
        echo json_encode(['error' => 'Service ID is required']);
        exit;
    }

    $service_id = intval($_GET['id']);

    // Fetch service with GST
    $sql = "SELECT id, service_name, service_desc, price, gst FROM service WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Service not found']);
        exit;
    }

    $service = $result->fetch_assoc();
    $stmt->close();

    // Fetch add-ons for this service
    $addon_sql = "SELECT adds_on as name, price FROM service_adds_on WHERE service_id = ?";
    $addon_stmt = $conn->prepare($addon_sql);
    $addon_stmt->bind_param("i", $service_id);
    $addon_stmt->execute();
    $addon_result = $addon_stmt->get_result();

    $addons = [];
    while ($addon_row = $addon_result->fetch_assoc()) {
        $addons[] = [
            'name' => $addon_row['name'],
            'price' => floatval($addon_row['price'])
        ];
    }
    $addon_stmt->close();

    // Prepare response with GST
    $response = [
        'id' => $service['id'],
        'service_name' => $service['service_name'],
        'service_desc' => $service['service_desc'],
        'price' => floatval($service['price']),
        'gst' => $service['gst'] !== null ? floatval($service['gst']) : 0,
        'addons' => $addons
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>