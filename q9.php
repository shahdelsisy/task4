<?php
require 'auth.php'; 
require 'db.php';  

$cities = [];
$city_result = mysqli_query($conn, "SELECT DISTINCT city FROM customers WHERE city IS NOT NULL AND city != '' ORDER BY city ASC");
if ($city_result) {
    while ($row = mysqli_fetch_assoc($city_result)) {
        $cities[] = $row['city'];
    }
}

$customers = [];
$selected_city = "";

if (isset($_GET['city']) && !empty(trim($_GET['city']))) {
    $selected_city = trim($_GET['city']);
    
    $sql = "SELECT id, first_name, email, city, money 
            FROM customers 
            WHERE city = ? 
            ORDER BY money DESC 
            LIMIT 3";
            
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $selected_city);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top 3 Richest Customers by City</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Top 3 Richest Customers by City (Question 9)</h2>

        <div class="card p-4 shadow mb-4 bg-white" style="max-width: 500px;">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="city" class="form-label">Select City:</label>
                    <select name="city" id="city" class="form-select" required>
                        <option value="" disabled <?= empty($selected_city) ? 'selected' : '' ?>>-- Choose City --</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= htmlspecialchars($city) ?>" <?= ($selected_city === $city) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($city) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>

        <?php if (!empty($selected_city)): ?>
            <h4 class="mb-3">Top 3 Richest Customers in "<?= htmlspecialchars($selected_city) ?>"</h4>
            <table class="table table-bordered table-striped bg-white shadow">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Money</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($customers) > 0): ?>
                        <?php $rank = 1; foreach ($customers as $cust): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-warning text-dark fs-6">#<?= $rank++ ?></span>
                                </td>
                                <td><?= htmlspecialchars($cust['first_name']) ?></td>
                                <td><?= htmlspecialchars($cust['email']) ?></td>
                                <td><?= htmlspecialchars($cust['city']) ?></td>
                                <td>
                                    <strong class="text-success">$<?= number_format($cust['money']) ?></strong>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No customers found in this city.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>