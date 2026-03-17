<?php
require_once '../php/db.php';

function getCustomerClasses() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, class_name FROM customer_classes ORDER BY class_name");
    return $stmt->fetchAll();
}

// For AJAX or direct call
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(getCustomerClasses());
}
?>