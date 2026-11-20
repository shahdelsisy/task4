<?php
require 'auth.php'; 
require 'db.php';  

$customers = [];
$search = "";

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    
    $searchTerm = "%" . $search . "%";
    $stmt = mysqli_prepare($conn, "SELECT id, first_name, email, city, money FROM customers WHERE first_name LIKE ?");
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $customers[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Customer by Name</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Search Customers by Name (Question 6)</h2>

        <div class="card p-4 shadow mb-4 bg-white" style="max-width: 500px;">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="search" class="form-label">Enter Customer Name:</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="username..." value="<?= htmlspecialchars($search) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </form>
        </div>

        <?php if (!empty($search)): ?>
            <h4 class="mb-3">Search Results for "<?= htmlspecialchars($search) ?>"</h4>
            <table class="table table-bordered table-striped bg-white shadow">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Money</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($customers) > 0): ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= $customer['id'] ?></td>
                                <td><?= htmlspecialchars($customer['first_name']) ?></td>
                                <td><?= htmlspecialchars($customer['email']) ?></td>
                                <td><?= htmlspecialchars($customer['city']) ?></td>
                                <td><?= number_format($customer['money']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No customers found matching this name.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>