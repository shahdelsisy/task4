<?php
require 'auth.php'; 
require 'db.php'; 

$product_id = "";
$product_details = [];
$total_sold = 0;
$order_ids = [];
$customers = [];

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    
    $sql_total = "SELECT SUM(quantity) as total FROM order_items WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql_total);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $res_total = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res_total)) {
        $total_sold = $row['total'] ? $row['total'] : 0;
    }
    mysqli_stmt_close($stmt);

    $sql_orders = "SELECT DISTINCT order_id FROM order_items WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql_orders);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $res_orders = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res_orders)) {
        $order_ids[] = $row['order_id'];
    }
    mysqli_stmt_close($stmt);

    $sql_cust = "SELECT DISTINCT c.id, c.first_name, c.email, c.city, c.money 
                 FROM customers c 
                 JOIN orders o ON c.id = o.customer_id 
                 JOIN order_items oi ON o.id = oi.order_id 
                 WHERE oi.product_id = ? 
                 ORDER BY c.money DESC";
    $stmt = mysqli_prepare($conn, $sql_cust);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $res_cust = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res_cust)) {
        $customers[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details & Buyers (Question 10)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Product Analysis & Buyers (Question 10)</h2>

        <div class="card p-4 shadow mb-4 bg-white" style="max-width: 500px;">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Enter Product ID:</label>
                    <input type="number" name="product_id" id="product_id" class="form-control" placeholder="e.g. 1" value="<?= htmlspecialchars($product_id) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>

        <?php if ($product_id !== ""): ?>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow bg-white">
                        <h5>Total Sold Quantity:</h5>
                        <p class="fs-4 text-success fw-bold"><?= number_format($total_sold) ?> units</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 shadow bg-white">
                        <h5>Order IDs containing this product:</h5>
                        <p class="fs-5 text-primary">
                            <?php if (count($order_ids) > 0): ?>
                                <?= implode(', ', $order_ids) ?>
                            <?php else: ?>
                                <span class="text-muted">None</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">Customers who bought this product (Sorted by Wealth)</h4>
            <table class="table table-bordered table-striped bg-white shadow">
                <thead class="table-dark">
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Money</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($customers) > 0): ?>
                        <?php foreach ($customers as $cust): ?>
                            <tr>
                                <td><?= $cust['id'] ?></td>
                                <td><?= htmlspecialchars($cust['first_name']) ?></td>
                                <td><?= htmlspecialchars($cust['email']) ?></td>
                                <td><?= htmlspecialchars($cust['city']) ?></td>
                                <td><strong class="text-success">$<?= number_format($cust['money']) ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No customers found for this product.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>