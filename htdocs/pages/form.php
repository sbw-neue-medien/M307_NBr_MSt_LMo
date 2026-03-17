<?php
session_start();
require_once '../php/db.php';
require_once '../php/get_customer_classes.php';

$classes = getCustomerClasses();
$form_data = $_SESSION['form_data'] ?? [];
$errors = $_SESSION['errors'] ?? [];
$message = $_SESSION['message'] ?? '';

unset($_SESSION['form_data'], $_SESSION['errors'], $_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Add New Customer</h1>
        <nav>
            <a href="customers.php">View Customers</a>
        </nav>
    </header>
    <main>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="../php/save_customer.php" method="post">
            <fieldset>
                <legend>Customer Information</legend>
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($form_data['customer_name'] ?? ''); ?>" required>

                <label for="contact_person">Contact Person:</label>
                <input type="text" id="contact_person" name="contact_person" value="<?php echo htmlspecialchars($form_data['contact_person'] ?? ''); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>" required>

                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($form_data['street'] ?? ''); ?>" required>

                <label for="postal_code">Postal Code:</label>
                <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($form_data['postal_code'] ?? ''); ?>" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($form_data['city'] ?? ''); ?>" required>

                <label for="customer_class">Customer Class:</label>
                <select id="customer_class" name="customer_class" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>" <?php echo ($form_data['customer_class'] ?? '') == $class['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="newsletter">Newsletter:</label>
                <input type="checkbox" id="newsletter" name="newsletter" <?php echo isset($form_data['newsletter']) ? 'checked' : ''; ?>>

                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes"><?php echo htmlspecialchars($form_data['notes'] ?? ''); ?></textarea>

                <button type="submit">Save Customer</button>
            </fieldset>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Customer Management System</p>
    </footer>
    <script src="../js/script.js"></script>
</body>
</html>