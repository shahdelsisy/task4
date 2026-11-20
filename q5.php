<?php
require 'auth.php'; 
require 'db.php';  

$sql = "SELECT e.id AS emp_id, e.name AS emp_name, m.name AS mgr_name 
        FROM employees e 
        LEFT JOIN employees m ON e.manager_id = m.id 
        ORDER BY e.id ASC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employees and Managers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <h2 class="mb-4">Employees and Their Managers (Question 5 - Self Join)</h2>
        
        <table class="table table-bordered table-striped bg-white shadow">
            <thead class="table-dark">
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Manager Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['emp_id'] ?></td>
                            <td><?= htmlspecialchars($row['emp_name'] ?? 'N/A') ?></td>
                            <td>
                                <?php if (!empty($row['mgr_name'])): ?>
                                    <span class="badge bg-success"><?= htmlspecialchars($row['mgr_name']) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Top Manager (No Boss)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No employees found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>