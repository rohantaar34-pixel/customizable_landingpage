<?php
// get-services.php

include "../includes/config.php";

header('Content-Type: application/json');

$conn = conn();

try {
    // Fetch all services with GST
    $sql = "SELECT id, service_name, service_desc, price, gst FROM service ORDER BY id DESC";
    $result = $conn->query($sql);

    $services = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $service_id = $row['id'];

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

            // Add service with all data including GST
            $services[] = [
                'id' => $row['id'],
                'service_name' => $row['service_name'],
                'service_desc' => $row['service_desc'],
                'price' => floatval($row['price']),
                'gst' => $row['gst'] !== null ? floatval($row['gst']) : 0,
                'addons' => $addons
            ];
        }
    }

    echo json_encode($services);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>