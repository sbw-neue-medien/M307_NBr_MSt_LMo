<?php
require_once '../php/db.php';

function validateInput($data) {
    $errors = [];

    if (empty($data['customer_name'])) {
        $errors[] = 'Customer name is required.';
    }
    if (empty($data['contact_name'])) {
        $errors[] = 'Contact name is required.';
    }
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($data['phone']) || !preg_match('/^\+?[0-9\s\-\(\)]+$/', $data['phone'])) {
        $errors[] = 'Valid phone number is required.';
    }
    if (empty($data['street'])) {
        $errors[] = 'Street is required.';
    }
    if (empty($data['postal_code'])) {
        $errors[] = 'Postal code is required.';
    }
    if (empty($data['city'])) {
        $errors[] = 'City is required.';
    }
    if (empty($data['customer_class_id'])) {
        $errors[] = 'Customer class is required.';
    }

    return $errors;
}

function sanitizeInput($data) {
    return array_map('htmlspecialchars', $data);
}

function createCustomer($data) {
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO customers (customer_name, customer_class_id, birth_date, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$data['customer_name'], $data['customer_class_id'], $data['birth_date'] ?: null]);

    return $pdo->lastInsertId();
}

function addAddress($customerId, $data) {
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO addresses (customer_id, street, postal_code, city, country) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$customerId, $data['street'], $data['postal_code'], $data['city'], $data['country'] ?? 'Switzerland']);
}

function addContact($customerId, $data) {
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO contacts (customer_id, contact_name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->execute([$customerId, $data['contact_name'], $data['email'], $data['phone']]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = sanitizeInput($_POST);
    $errors = validateInput($data);

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $customerId = createCustomer($data);
            addAddress($customerId, $data);
            addContact($customerId, $data);

            $pdo->commit();

            header('Location: ../pages/customers.php?message=Customer successfully created');
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Error saving data: ' . $e->getMessage();
        }
    }

    // If errors, redirect back with errors and data
    $query = http_build_query(['errors' => $errors, 'data' => $data]);
    header('Location: ../pages/form.php?' . $query);
    exit;
}
?>