<?php
// DEV ONLY: restablece la clave del admin a 'admin123'
require __DIR__ . '/../config/db.php';

try {
    $pdo = (new Database())->getConnection();
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES ('admin', ?, 'admin') ON DUPLICATE KEY UPDATE password_hash=VALUES(password_hash), role='admin'")
        ->execute([$hash]);
    echo "OK: contraseña de 'admin' restablecida a 'admin123'";
} catch (Throwable $e) {
    http_response_code(500);
    echo 'ERROR: ' . $e->getMessage();
}
