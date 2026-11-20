<?php
require 'auth.php'; 
require 'db.php';  

$cities = [];
$city_sql = "SELECT DISTINCT city FROM customers WHERE city IS NOT NULL AND city != '' ORDER BY city ASC";
$city_result = mysqli_query($conn, $city_sql);
if ($city_result) {
    while ($row = mysqli_fetch_assoc($city_result)) {
        $cities[] = $row['city'];
    }
}

$customers = [];
$selected_city = "";

if (isset($_GET['city']) && !empty(trim($_GET['city']))) {
    $selected_city = trim($_GET['city']);
    
    $stmt = mysqli_prepare($conn, "SELECT id, first_name, email, city, money FROM customers WHERE city = ? ORDER BY first_name ASC");
    mysqli_stmt_bind_param($stmt, "s", $selected_city);
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
    <title>Customers by City</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Customers by City (Question 7)</h2>

        <div class="card p-4 shadow mb-4 bg-white" style="max-width: 500px;">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="city" class="form-label">Select a City:</label>
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
            <h4 class="mb-3">Customers in "<?= htmlspecialchars($selected_city) ?>" (Sorted Alphabetically)</h4>
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
                            <td colspan="5" class="text-center">No customers found in this city.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>