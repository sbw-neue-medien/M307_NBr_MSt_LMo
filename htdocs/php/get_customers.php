<?php
require_once '../php/db.php';

function getAllCustomers() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT c.id, c.customer_name, c.contact_person, c.email, c.phone, cc.class_name as customer_class
        FROM customers c
        LEFT JOIN customer_classes cc ON c.customer_class = cc.id
        ORDER BY c.created_at DESC
    ");
    return $stmt->fetchAll();
}

// For AJAX or direct call
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(getAllCustomers());
}
?>