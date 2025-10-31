<?php
header('Content-Type: text/plain; charset=utf-8');
require __DIR__ . '/../config/db.php';

try {
    $pdo = (new Database())->getConnection();
    echo "OK: conexión PDO establecida\n";
    $stmt = $pdo->query('SELECT 1');
    echo "SELECT 1 => " . $stmt->fetchColumn() . "\n";
    echo "Drivers disponibles: " . implode(',', PDO::getAvailableDrivers()) . "\n";
} catch (Throwable $e) {
    http_response_code(500);
    echo "ERROR: " . $e->getMessage() . "\n";
}
