<?php
$title = 'All Customers';
require_once '../includes/header.php';
require_once '../php/get_customers.php';

$customers = getAllCustomers();
$message = $_GET['message'] ?? '';
?>

<section>
    <h2>All Customers</h2>
    <?php if ($message): ?>
        <div class="success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Contact Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Birth Date</th>
                <th>Customer Class</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['id']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['contact_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                    <td><?php echo htmlspecialchars($customer['street'] . ', ' . $customer['postal_code'] . ' ' . $customer['city'] . ', ' . $customer['country']); ?></td>
                    <td><?php echo htmlspecialchars($customer['birth_date'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_class']); ?></td>
                    <td><?php echo htmlspecialchars($customer['created_at']); ?></td>
                    <td><a href="edit_customer.php?id=<?php echo htmlspecialchars($customer['id']); ?>" class="edit-link">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once '../includes/footer.php'; ?>