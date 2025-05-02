<?php
include 'connection.inc.php';
include 'top.inc.php';

// Fetch all orders with billing addresses
$stmt = $conn->prepare("
    SELECT 
        o.id AS order_id, o.user_id, o.total_amount, o.order_date, 
        b.full_name, b.phone, b.address, b.city, b.state, b.zip_code, b.country
    FROM orders o
    LEFT JOIN billing_addresses b ON o.id = b.order_id
    ORDER BY o.order_date DESC
");
$stmt->execute();
$orders = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Orders</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2 style="text-align: center; color: blue;">All Orders</h2>

    <table style="width: 100%; border-collapse: collapse; border: 2px solid black;">
        <tr style="background-color: #f2f2f2;">
            <th style="padding: 10px; border: 1px solid black;">Order ID</th>
            <th style="padding: 10px; border: 1px solid black;">User ID</th>
            <th style="padding: 10px; border: 1px solid black;">Total Amount</th>
            <th style="padding: 10px; border: 1px solid black;">Order Date</th>
            <th style="padding: 10px; border: 1px solid black;">Billing Address</th>
            <th style="padding: 10px; border: 1px solid black;">Ordered Items</th>
        </tr>

        <?php while ($order = $orders->fetch_assoc()): ?>
            <tr>
                <td style="padding: 10px; border: 1px solid black;"><?php echo $order['order_id']; ?></td>
                <td style="padding: 10px; border: 1px solid black;"><?php echo $order['user_id']; ?></td>
                <td style="padding: 10px; border: 1px solid black;">Rs.<?php echo number_format($order['total_amount'], 2); ?></td>
                <td style="padding: 10px; border: 1px solid black;"><?php echo $order['order_date']; ?></td>
                <td style="padding: 10px; border: 1px solid black;">
                    <strong><?php echo htmlspecialchars($order['full_name']); ?></strong><br>
                    <?php echo htmlspecialchars($order['phone']); ?><br>
                    <?php echo htmlspecialchars($order['address']); ?>, 
                    <?php echo htmlspecialchars($order['city']); ?>, 
                    <?php echo htmlspecialchars($order['state']); ?> - 
                    <?php echo htmlspecialchars($order['zip_code']); ?><br>
                    <?php echo htmlspecialchars($order['country']); ?>
                </td>
                <td style="padding: 10px; border: 1px solid black;">
                    <?php
                    // Fetch order items for this order
                    $stmt = $conn->prepare("
                        SELECT p.name, oi.quantity, oi.price 
                        FROM order_items oi 
                        JOIN product p ON oi.product_id = p.id 
                        WHERE oi.order_id = ?
                    ");
                    $stmt->bind_param("i", $order['order_id']);
                    $stmt->execute();
                    $items = $stmt->get_result();
                    $stmt->close();
                    
                    echo "<ul style='margin: 0; padding-left: 15px;'>";
                    while ($item = $items->fetch_assoc()) {
                        echo "<li><strong>" . htmlspecialchars($item['name']) . "</strong> - ";
                        echo $item['quantity'] . " pcs @ Rs." . number_format($item['price'], 2) . "</li>";
                    }
                    echo "</ul>";
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="admin_dashboard.php" style="display: inline-block; padding: 10px 20px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;">Back to Dashboard</a>

</body>
</html>

<?php include 'footer.inc.php'; ?>

