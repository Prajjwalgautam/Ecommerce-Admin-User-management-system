<?php
include("partials/database.php");
include("tables.php");

header('Content-Type: application/json');

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    exit;
}

$id = (int)$_GET['id'];
$action = $_GET['action'];

if ($action !== 'edit') {
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM catalog WHERE catalog_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Item not found']);
        exit;
    }

    $row = $result->fetch_assoc();

    $html = '
    <input type="hidden" name="catalog_id" value="' . $row['catalog_id'] . '">
    <div class="form-group">
        <label>Catalog Name</label>
        <input type="text" class="form-control" name="catalog_name" value="' . htmlspecialchars($row['catalog_name']) . '" required>
    </div>
    <div class="form-group">
        <label>Stock</label>
        <input type="number" class="form-control" name="stock" value="' . $row['stock'] . '" required>
    </div>';

    echo json_encode(['success' => true, 'html' => $html]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
