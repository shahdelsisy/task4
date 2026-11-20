<?php
require 'auth.php'; 
require 'db.php';

$sql = "SELECT id, first_name, email, money, city FROM customers WHERE money > 20000";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers > 20,000</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Customers with Money > 20,000</h2>
        
        <table class="table table-bordered table-striped bg-white shadow">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Money</th>
                    <th>City</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['first_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= number_format($row['money']) ?></td>
                            <td><?= htmlspecialchars($row['city']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No customers found with money > 20,000.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>