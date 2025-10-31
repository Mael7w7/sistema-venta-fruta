<?php
require __DIR__ . '/_auth.php';
require __DIR__ . '/../config/db.php';
$pdo = (new Database())->getConnection();

$totales = $pdo->query('SELECT COUNT(*) clientes FROM clientes')->fetch();
$totProd = $pdo->query('SELECT COUNT(*) productos FROM productos')->fetch();
$res = $pdo->query('SELECT COUNT(*) num_ventas, COALESCE(SUM(p.precio*v.cantidad),0) total
FROM ventas v JOIN productos p ON p.id=v.producto_id');
$ventas = $res->fetch();

ob_start();
?>
<div class="container">
    <h3 class="mb-4">Reportes</h3>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card card-minimal p-3">
                <div class="text-muted">Clientes</div>
                <div class="fs-3 fw-bold"><?= intval($totales['clientes'] ?? 0) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-minimal p-3">
                <div class="text-muted">Productos</div>
                <div class="fs-3 fw-bold"><?= intval($totProd['productos'] ?? 0) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-minimal p-3">
                <div class="text-muted">Ventas</div>
                <div class="fs-3 fw-bold"><?= intval($ventas['num_ventas'] ?? 0) ?></div>
                <div class="text-muted">Total: S/ <?= number_format(floatval($ventas['total'] ?? 0), 2) ?></div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
