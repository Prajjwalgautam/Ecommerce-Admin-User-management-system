<?php
include("partials/database.php");
include("tables.php");

header('Content-Type: application/json');

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['catalog_id']) || !isset($data['catalog_name']) || !isset($data['stock'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit;
}

$id = (int)$data['catalog_id'];
$name = trim($data['catalog_name']);
$stock = (int)$data['stock'];

try {
    $stmt = $conn->prepare("UPDATE catalog SET catalog_name = ?, stock = ?, updated_at = NOW() WHERE catalog_id = ?");
    $stmt->bind_param("sii", $name, $stock, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
