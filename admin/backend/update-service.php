<?php
// update-service.php

include "../includes/config.php";

header('Content-Type: application/json');

$conn = conn();

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$response = ['success' => false];

try {
    if (empty($data['id']) || empty($data['service_name']) || empty($data['service_desc'])) {
        $response['message'] = 'Missing required fields';
        echo json_encode($response);
        exit;
    }

    $price = isset($data['service_price']) ? floatval($data['service_price']) : 0.00;
    $gst_fee = (!empty($data['GST_FEE']) && $data['GST_FEE'] !== '') ? floatval($data['GST_FEE']) : null;

    $conn->begin_transaction();

    // Update service including GST
    $stmt = $conn->prepare("UPDATE service SET service_name = ?, service_desc = ?, price = ?, gst = ? WHERE id = ?");
    $stmt->bind_param("ssddi", $data['service_name'], $data['service_desc'], $price, $gst_fee, $data['id']);

    if ($stmt->execute()) {
        // Delete existing add-ons
        $delete_stmt = $conn->prepare("DELETE FROM service_adds_on WHERE service_id = ?");
        $delete_stmt->bind_param("i", $data['id']);
        $delete_stmt->execute();
        $delete_stmt->close();

        // Insert new add-ons
        if (!empty($data['addons']) && is_array($data['addons'])) {
            $addon_stmt = $conn->prepare("INSERT INTO service_adds_on (service_id, adds_on, price) VALUES (?, ?, ?)");

            foreach ($data['addons'] as $addon) {
                if (is_array($addon)) {
                    $addon_name = isset($addon['name']) ? trim($addon['name']) : '';
                    $addon_price = isset($addon['price']) ? floatval($addon['price']) : 0.00;

                    if (!empty($addon_name)) {
                        $addon_stmt->bind_param("isd", $data['id'], $addon_name, $addon_price);
                        $addon_stmt->execute();
                    }
                }
            }
            $addon_stmt->close();
        }

        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'Service updated successfully';
    } else {
        $conn->rollback();
        $response['message'] = 'Failed to update service';
    }

    $stmt->close();

} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = 'Error: ' . $e->getMessage();
}

$conn->close();

echo json_encode($response);
?>