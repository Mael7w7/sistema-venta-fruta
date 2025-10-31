<?php
session_start();
require __DIR__.'/config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /login.php'); exit; }

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

try {
    $pdo = (new Database())->getConnection();
} catch (Throwable $e) {
    header('Location: /login.php?error=db');
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash']) && $user['role'] === 'admin') {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        header('Location: /admin/index.php');
        exit;
    }
} catch (Throwable $e) {
    header('Location: /login.php?error=query');
    exit;
}

header('Location: /login.php?error=creds');
exit;


