
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$username = htmlspecialchars($_SESSION['username']);
$userId = (int)$_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SessionAuthSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">SessionAuthSystem</a>
        <span class="navbar-text me-auto ms-3">Dashboard</span>
        <span class="text-white me-3"><i class="bi bi-person-circle"></i> <?= $username ?></span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</nav>


<div class="container py-5">
    <div class="p-5 mb-4 bg-white rounded shadow-sm">
        <h1 class="fw-bold text-primary">Welcome, <?= $username ?>!</h1>
        <p class="lead text-muted">This page is protected and only visible to logged-in users.</p>
        <a href="#" class="btn btn-primary">Explore Dashboard</a>
    </div>


    <div class="row g-4">
        <div class="col-md-4">
            <h5><i class="bi bi-shield-check"></i> Account Status</h5>
            <p class="text-muted">Your session is active and protected against Session Fixation using session_regenerate_id(true).</p>
        </div>
        <div class="col-md-4">
            <h5><i class="bi bi-person-lines-fill"></i> User Details</h5>
            <p class="mb-1"><strong>User ID:</strong> <?= $userId ?></p>
            <p><strong>Username:</strong> <?= $username ?></p>
        </div>
        <div class="col-md-4">
            <h5><i class="bi bi-key"></i> Active Session ID</h5>
            <p class="mb-1"><strong>Current Session ID:</strong></p>
            <code><?= htmlspecialchars(session_id()) ?></code>
            <p class="small text-muted mt-2">Generated after login via session_regenerate_id(true).</p>
        </div>
    </div>
</div>
</body>
</html>
?>