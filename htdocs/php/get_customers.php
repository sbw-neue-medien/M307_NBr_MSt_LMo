<?php
require_once '../php/db.php';

function getAllCustomers() {
    global $pdo;

    $stmt = $pdo->query("SELECT co.id, co.customer_name, co.class_name AS customer_class, co.created_at, c.birth_date, con.contact_name, con.email, con.phone, a.street, a.postal_code, a.city, a.country FROM customer_overview co LEFT JOIN customers c ON co.id = c.id LEFT JOIN contacts con ON co.id = con.customer_id LEFT JOIN addresses a ON co.id = a.customer_id ORDER BY co.created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCustomerById($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT c.id, c.customer_name, c.customer_class_id, c.birth_date, co.created_at, con.contact_name, con.email, con.phone, a.street, a.postal_code, a.city, a.country FROM customers c LEFT JOIN customer_overview co ON c.id = co.id LEFT JOIN contacts con ON c.id = con.customer_id LEFT JOIN addresses a ON c.id = a.customer_id WHERE c.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCustomerClasses() {
    global $pdo;

    $stmt = $pdo->query("SELECT id, class_name FROM customer_classes ORDER BY class_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>