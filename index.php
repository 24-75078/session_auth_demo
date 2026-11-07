<?php
session_start();
require "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';


    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();


    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    }
    $error = "Invalid username/email or password.";
}
$registered = isset($_GET['registered']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - AuthSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>body{background:#eef3fb;}.icon-circle{width:56px;height:56px;border-radius:50%;background:#0d6efd;color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin:0 auto 12px;}</style>
</head>
<body class="d-flex align-items-center min-vh-100">
<div class="container" style="max-width:420px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="icon-circle"><i class="bi bi-person-fill"></i></div>
            <h3 class="text-center fw-bold">Welcome Back!~</h3>
            <p class="text-center text-muted">Sign in to your account.</p>


            <?php if ($registered): ?>
                <div class="alert alert-success py-2">Account created! Please log in.</div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>


            <form method="POST">
                <label class="form-label fw-semibold">Username or Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="login" class="form-control" placeholder="Enter username or email" required>
                </div>
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
                <button class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
            </form>
            <p class="text-center mt-3 mb-0">No account? <a href="register.php">Register Here</a></p>
        </div>
    </div>
</div>
</body>
</html>
