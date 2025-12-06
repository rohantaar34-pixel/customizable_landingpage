<?php
//delete-service.php

include "../includes/config.php";

header('Content-Type: application/json');

$conn = conn();

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$response = ['success' => false];

try {
    // Validate input
    if (empty($data['id'])) {
        $response['message'] = 'Service ID is required';
        echo json_encode($response);
        exit;
    }

    $service_id = intval($data['id']);

    // Begin transaction
    $conn->begin_transaction();

    // Delete add-ons first (foreign key constraint)
    $delete_addons_stmt = $conn->prepare("DELETE FROM service_adds_on WHERE service_id = ?");
    $delete_addons_stmt->bind_param("i", $service_id);
    $delete_addons_stmt->execute();
    $delete_addons_stmt->close();

    // Delete service
    $delete_service_stmt = $conn->prepare("DELETE FROM service WHERE id = ?");
    $delete_service_stmt->bind_param("i", $service_id);

    if ($delete_service_stmt->execute()) {
        // Commit transaction
        $conn->commit();

        $response['success'] = true;
        $response['message'] = 'Service deleted successfully';
    } else {
        $conn->rollback();
        $response['message'] = 'Failed to delete service';
    }

    $delete_service_stmt->close();

} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = 'Error: ' . $e->getMessage();
}

$conn->close();

echo json_encode($response);
?>