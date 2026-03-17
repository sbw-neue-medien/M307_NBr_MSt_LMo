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

function updateCustomer($id, $data) {
    global $pdo;

    $stmt = $pdo->prepare("UPDATE customers SET customer_name = ?, customer_class_id = ?, birth_date = ? WHERE id = ?");
    $stmt->execute([$data['customer_name'], $data['customer_class_id'], $data['birth_date'] ?: null, $id]);
}

function updateAddress($customerId, $data) {
    global $pdo;

    // Check if address exists
    $stmt = $pdo->prepare("SELECT id FROM addresses WHERE customer_id = ?");
    $stmt->execute([$customerId]);
    $address = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($address) {
        $stmt = $pdo->prepare("UPDATE addresses SET street = ?, postal_code = ?, city = ?, country = ? WHERE customer_id = ?");
        $stmt->execute([$data['street'], $data['postal_code'], $data['city'], $data['country'] ?? 'Switzerland', $customerId]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO addresses (customer_id, street, postal_code, city, country) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$customerId, $data['street'], $data['postal_code'], $data['city'], $data['country'] ?? 'Switzerland']);
    }
}

function updateContact($customerId, $data) {
    global $pdo;

    // Check if contact exists
    $stmt = $pdo->prepare("SELECT id FROM contacts WHERE customer_id = ?");
    $stmt->execute([$customerId]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($contact) {
        $stmt = $pdo->prepare("UPDATE contacts SET contact_name = ?, email = ?, phone = ? WHERE customer_id = ?");
        $stmt->execute([$data['contact_name'], $data['email'], $data['phone'], $customerId]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO contacts (customer_id, contact_name, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$customerId, $data['contact_name'], $data['email'], $data['phone']]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if (!$id) {
        die('Customer ID is required.');
    }

    $data = sanitizeInput($_POST);
    $errors = validateInput($data);

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            updateCustomer($id, $data);
            updateAddress($id, $data);
            updateContact($id, $data);

            $pdo->commit();

            header('Location: ../pages/customers.php?message=Customer updated successfully');
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Error updating data: ' . $e->getMessage();
        }
    }

    // If errors, redirect back with errors and data
    $query = http_build_query(['errors' => $errors, 'data' => $data]);
    header('Location: ../pages/edit_customer.php?id=' . $id . '&' . $query);
    exit;
}
?>