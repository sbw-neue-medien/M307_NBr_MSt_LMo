<?php
session_start();
require_once '../php/db.php';

function validateInput($data) {
    $errors = [];

    // Required fields
    $required = ['customer_name', 'contact_person', 'email', 'phone', 'street', 'postal_code', 'city', 'customer_class'];
    foreach ($required as $field) {
        if (empty(trim($data[$field]))) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }

    // Email validation
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Phone validation (simple: digits, spaces, hyphens, parentheses)
    if (!empty($data['phone']) && !preg_match('/^[\d\s\-\(\)]+$/', $data['phone'])) {
        $errors[] = 'Invalid phone format.';
    }

    return $errors;
}

function createCustomer($data) {
    global $pdo;

    // Sanitize
    $customer_name = htmlspecialchars(trim($data['customer_name']));
    $contact_person = htmlspecialchars(trim($data['contact_person']));
    $email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($data['phone']));
    $customer_class = (int)$data['customer_class'];
    $newsletter = isset($data['newsletter']) ? 1 : 0;
    $notes = htmlspecialchars(trim($data['notes']));

    // Insert customer
    $stmt = $pdo->prepare("INSERT INTO customers (customer_name, contact_person, email, phone, customer_class, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$customer_name, $contact_person, $email, $phone, $customer_class]);

    $customer_id = $pdo->lastInsertId();

    // Insert address
    $street = htmlspecialchars(trim($data['street']));
    $postal_code = htmlspecialchars(trim($data['postal_code']));
    $city = htmlspecialchars(trim($data['city']));

    $stmt = $pdo->prepare("INSERT INTO addresses (customer_id, street, postal_code, city) VALUES (?, ?, ?, ?)");
    $stmt->execute([$customer_id, $street, $postal_code, $city]);

    return $customer_id;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $errors = validateInput($data);

    if (empty($errors)) {
        try {
            createCustomer($data);
            $_SESSION['message'] = 'Customer successfully created';
            header('Location: ../pages/customers.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error saving data';
            $_SESSION['form_data'] = $data;
            header('Location: ../pages/form.html');
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $data;
        header('Location: ../pages/form.html');
        exit;
    }
} else {
    header('Location: ../pages/form.html');
    exit;
}
?>