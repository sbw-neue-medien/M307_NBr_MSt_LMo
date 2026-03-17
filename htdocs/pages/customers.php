<?php
session_start();
require_once '../php/db.php';
require_once '../php/get_customers.php';

$customers = getAllCustomers();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$title = 'View Customers';
include '../includes/header.php';
?>
<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>
<h2>All Customers</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Contact Person</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Customer Class</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?php echo htmlspecialchars($customer['id']); ?></td>
                <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($customer['contact_person']); ?></td>
                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                <td><?php echo htmlspecialchars($customer['customer_class']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>