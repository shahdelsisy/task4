<?php
require 'auth.php'; 
require 'db.php';  

$sql = "SELECT id, name, price, stock FROM products ORDER BY id ASC LIMIT 50";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products Catalog & Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Products Catalog (Stock Management)</h2>
        
        <table class="table table-bordered table-striped bg-white shadow">
            <thead class="table-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                            <td>$<?= number_format($row['price'] ?? 0, 2) ?></td>
                            <td>
                                <span class="badge bg-<?= ($row['stock'] ?? 0) > 10 ? 'success' : 'warning text-dark' ?>">
                                    <?= $row['stock'] ?? 0 ?> units
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>