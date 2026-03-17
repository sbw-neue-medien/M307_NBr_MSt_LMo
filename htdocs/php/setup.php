<?php
require_once 'db.php';

try {
    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS customer_classes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            class_name VARCHAR(100) NOT NULL
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS customers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(255) NOT NULL,
            contact_person VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) NOT NULL,
            customer_class INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (customer_class) REFERENCES customer_classes(id)
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS addresses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_id INT NOT NULL,
            street VARCHAR(255) NOT NULL,
            postal_code VARCHAR(20) NOT NULL,
            city VARCHAR(255) NOT NULL,
            FOREIGN KEY (customer_id) REFERENCES customers(id)
        )
    ");

    // Insert default classes
    $stmt = $pdo->prepare("INSERT IGNORE INTO customer_classes (id, class_name) VALUES (1, 'Standard'), (2, 'Premium'), (3, 'VIP')");
    $stmt->execute();

    echo "Database setup completed.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>