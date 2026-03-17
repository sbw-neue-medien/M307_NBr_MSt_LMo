<?php
$title = 'Edit Customer';
require_once '../includes/header.php';
require_once '../php/get_customers.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die('Customer ID is required.');
}

$customer = getCustomerById($id);
if (!$customer) {
    die('Customer not found.');
}

$customerClasses = getCustomerClasses();
$errors = $_GET['errors'] ?? [];
$data = $_GET['data'] ?? $customer; // Use existing data if no errors

?>

<section>
    <h2>Edit Customer</h2>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form id="customerForm" action="../php/update_customer.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <fieldset>
            <legend>Customer Information</legend>
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($data['customer_name'] ?? ''); ?>" required>

            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name" value="<?php echo htmlspecialchars($data['contact_name'] ?? ''); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>" required>

            <label for="street">Street:</label>
            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($data['street'] ?? ''); ?>" required>

            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($data['postal_code'] ?? ''); ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($data['city'] ?? ''); ?>" required>

            <label for="customer_class_id">Customer Class:</label>
            <select id="customer_class_id" name="customer_class_id" required>
                <option value="">Select Class</option>
                <?php foreach ($customerClasses as $class): ?>
                    <option value="<?php echo $class['id']; ?>" <?php echo ($data['customer_class_id'] ?? '') == $class['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="birth_date">Birth Date:</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($data['birth_date'] ?? ''); ?>">
        </fieldset>
        <button type="submit">Update Customer</button>
    </form>
</section>

<?php require_once '../includes/footer.php'; ?>
