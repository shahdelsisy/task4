<?php
require 'auth.php'; 
require 'db.php';  

$customer = null;
$error = "";

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = intval($_GET['id']); 

    $stmt = mysqli_prepare($conn, "SELECT id, first_name, email, money, city FROM customers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $customer = $row;
    } else {
        $error = "No customer found with ID: $id";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Customer by ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Search Customer by ID</h2>


        <div class="card p-4 shadow mb-4 bg-white" style="max-width: 500px;">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="id" class="form-label">Enter Customer ID:</label>
                     <input type="number" name="id" id="id" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </form>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger" style="max-width: 500px;"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($customer): ?>
            <div class="card shadow bg-white" style="max-width: 500px;">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Customer Details (ID: <?= $customer['id'] ?>)</h5>
                </div>
                <div class="card-body">
                    <p><strong>First Name:</strong> <?= htmlspecialchars($customer['first_name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
                    <p><strong>Money:</strong> <?= number_format($customer['money']) ?></p>
                    <p><strong>City:</strong> <?= htmlspecialchars($customer['city']) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>