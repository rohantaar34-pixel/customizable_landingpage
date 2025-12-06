<?php
//save_services.php

include "../includes/config.php";

header('Content-Type: application/json');

$conn = conn();

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$response = ['success' => false];

try {
    // Validate input
    if (empty($data['service_name']) || empty($data['service_desc'])) {
        $response['message'] = 'Service name and description are required';
        echo json_encode($response);
        exit;
    }

    // Validate price
    $price = isset($data['price']) ? floatval($data['price']) : 0.00;
    if ($price < 0) {
        $response['message'] = 'Price must be greater than or equal to 0';
        echo json_encode($response);
        exit;
    }

    // Handle GST_FEE - convert empty string to null
    $gst_fee = (!empty($data['GST_FEE']) && $data['GST_FEE'] !== '') ? floatval($data['GST_FEE']) : null;

    // Begin transaction
    $conn->begin_transaction();

    // Insert service with price and GST
    $stmt = $conn->prepare("INSERT INTO service (service_name, service_desc, price, gst) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdd", $data['service_name'], $data['service_desc'], $price, $gst_fee);

    if ($stmt->execute()) {
        $service_id = $conn->insert_id;

        // Insert add-ons if any
        if (!empty($data['addons']) && is_array($data['addons'])) {
            $addon_stmt = $conn->prepare("INSERT INTO service_adds_on (service_id, adds_on, price) VALUES (?, ?, ?)");

            foreach ($data['addons'] as $addon) {
                if (is_array($addon)) {
                    $addon_name = isset($addon['name']) ? trim($addon['name']) : '';
                    $addon_price = isset($addon['price']) ? floatval($addon['price']) : 0.00;

                    if (!empty($addon_name)) {
                        $addon_stmt->bind_param("isd", $service_id, $addon_name, $addon_price);
                        $addon_stmt->execute();
                    }
                } else {
                    if (!empty(trim($addon))) {
                        $addon_price = 0.00;
                        $addon_stmt->bind_param("isd", $service_id, $addon, $addon_price);
                        $addon_stmt->execute();
                    }
                }
            }
            $addon_stmt->close();
        }

        // Commit transaction
        $conn->commit();

        $response['success'] = true;
        $response['message'] = 'Service added successfully';
        $response['service_id'] = $service_id;
    } else {
        $conn->rollback();
        $response['message'] = 'Failed to add service';
    }

    $stmt->close();

} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = 'Error: ' . $e->getMessage();
}

$conn->close();

echo json_encode($response);
?>