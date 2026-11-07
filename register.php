<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($username === '' || $password === '') {
        $error = "Please fill in all fields.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();


        if ($stmt->num_rows > 0) {
            $error = "Username already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $ins->bind_param("ss", $username, $hash);


            if ($ins->execute()) {
                $success = "Account created! You can now log in.";
            } else {
                $error = "Registration failed. Please try again.";
            }
            $ins->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Account</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f2f5;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: #fff;
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #555;
            margin: 0 0 20px;
        }
        label {
            display: block;
            color: #555;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover { background: #218838; }
        .link {
            text-align: center;
            margin-top: 15px;
            color: #555;
            font-size: 14px;
        }
        .link a {
            color: #0275d8;
            font-weight: bold;
        }
        .msg {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }
        .error { background: #f8d7da; color: #721c24; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Register Account</h2>


        <?php if ($error): ?>
            <div class="msg error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="msg success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>


        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" placeholder = "Enter Username" id="username" name="username" required>


            <label for="email">Email</label>
            <input type="text" placeholder = "Enter Email" id="email" name="email" required>


            <label for="password">Password</label>
            <input type="password" placeholder = "Enter Password" id="password" name="password" required>


            <button type="submit">Register here</button>
        </form>


        <div class="link">
            Already have an account? <a href="index.php">Back to Login</a>
        </div>
    </div>
</body>
</html>


