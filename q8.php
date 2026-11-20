<?php
require 'auth.php'; 
require 'db.php';  

$products = [];
$number = "";

if (isset($_GET['number']) && is_numeric($_GET['number'])) {
    $number = intval($_GET['number']);
    
    $sql = "SELECT p.name, SUM(oi.quantity) AS total_quantity 
            FROM products p 
            JOIN order_items oi ON p.id = oi.product_id 
            GROUP BY p.id, p.name 
            HAVING total_quantity > ? 
            ORDER BY total_quantity DESC";
            
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $number);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products by Total Quantity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Products with Total Quantity Greater Than Input (Question 8)</h2>

        <div class="card p-4 shadow mb-4 bg-white" style="max-width: 500px;">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="number" class="form-label">Enter Minimum Total Quantity (100 to 5000):</label>
                    <input type="number" name="number" id="number" class="form-control" min="100" max="5000" placeholder="e.g. 300" value="<?= htmlspecialchars($number) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>

        <?php if ($number !== ""): ?>
            <h4 class="mb-3">Products with Total Sold Quantity > <?= htmlspecialchars($number) ?></h4>
            <table class="table table-bordered table-striped bg-white shadow">
                <thead class="table-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Total Sold Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $prod): ?>
                            <tr>
                                <td><?= htmlspecialchars($prod['name']) ?></td>
                                <td>
                                    <span class="badge bg-success fs-6"><?= number_format($prod['total_quantity']) ?> units</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">No products found with total quantity greater than <?= htmlspecialchars($number) ?>.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>