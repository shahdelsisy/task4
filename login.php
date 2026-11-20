<?php
require 'db.php'; 
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');


    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
        $error = "Invalid email format.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, first_name, password FROM customers WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Wrong email or password! (Try default password: 123456)";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items:center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center mb-3">Login</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger p-2"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>