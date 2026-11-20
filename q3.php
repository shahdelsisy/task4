<?php
require 'auth.php'; 
require 'db.php';  


$sql = "SELECT c.id, c.first_name, c.email, c.city, COUNT(o.id) AS total_orders 
        FROM customers c 
        LEFT JOIN orders o ON c.id = o.customer_id 
        GROUP BY c.id, c.first_name, c.email, c.city 
        ORDER BY total_orders DESC 
        LIMIT 50"; 

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers & Their Orders Count</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Customers and Total Orders Count</h2>
        
        <table class="table table-bordered table-striped bg-white shadow">
            <thead class="table-dark">
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['first_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['city']) ?></td>
                            <td>
                                <span class="badge bg-<?= $row['total_orders'] > 0 ? 'success' : 'secondary' ?>">
                                    <?= $row['total_orders'] ?> orders
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No data found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>