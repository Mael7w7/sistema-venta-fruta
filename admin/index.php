<?php
require __DIR__ . '/_auth.php';
require __DIR__ . '/../config/db.php';

try {
    $pdo = (new Database())->getConnection();
    
    // Obtener estadísticas
    $clientes_count = $pdo->query('SELECT COUNT(*) as total FROM clientes')->fetch()['total'];
    $productos_count = $pdo->query('SELECT COUNT(*) as total FROM productos')->fetch()['total'];
    $ventas_count = $pdo->query('SELECT COUNT(*) as total FROM ventas')->fetch()['total'];
    $ingresos = $pdo->query('
        SELECT COALESCE(SUM(p.precio * v.cantidad), 0) as total 
        FROM ventas v 
        JOIN productos p ON p.id = v.producto_id
    ')->fetch()['total'];

    $stats = [
        'clientes' => ['count' => $clientes_count, 'icon' => 'bi-people', 'label' => 'Clientes registrados'],
        'productos' => ['count' => $productos_count, 'icon' => 'bi-box-seam', 'label' => 'Productos activos'],
        'ventas' => ['count' => $ventas_count, 'icon' => 'bi-receipt', 'label' => 'Ventas realizadas'],
        'ingresos' => ['count' => 'S/ ' . number_format($ingresos, 2), 'icon' => 'bi-graph-up', 'label' => 'Ingresos totales']
    ];

ob_start(); ?>
<div class="container">
    <div class="page-header">
        <h2 class="page-title">
            <i class="bi bi-grid"></i>
            Dashboard
        </h2>
        <div class="btn-group">
            <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-download me-1"></i> Exportar
            </button>
            <button class="btn btn-sm" style="background-color: #00916E; color: white;">
                <i class="bi bi-plus-lg me-1"></i> Nueva venta
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <?php 
        $colors = [
            'clientes' => '#00916E',    // Verde
            'productos' => '#EC9F05',   // Naranja
            'ventas' => '#F7E733',      // Amarillo
            'ingresos' => '#00916E'     // Verde
        ];
        foreach ($stats as $key => $stat): 
        ?>
            <div class="col-md-6 col-lg-3">
                <div class="card card-minimal">
                    <div class="dashboard-stat">
                        <div class="dashboard-stat-icon" style="background-color: <?= $colors[$key] ?>; color: <?= ($key == 'ventas') ? '#000' : '#fff' ?>;">
                            <i class="bi <?= $stat['icon'] ?>"></i>
                        </div>
                        <div class="dashboard-stat-info">
                            <h3><?= $stat['count'] ?></h3>
                            <p><?= $stat['label'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-minimal">
                <div class="card-body">
                    <h5 class="card-title mb-3" style="color: #EC9F05;">Últimas ventas</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #F7E733;">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ventas_recientes = $pdo->query('
                                    SELECT 
                                        c.nombre as cliente,
                                        p.nombre as producto,
                                        v.cantidad,
                                        (p.precio * v.cantidad) as total,
                                        v.fecha
                                    FROM ventas v
                                    JOIN clientes c ON c.id = v.cliente_id
                                    JOIN productos p ON p.id = v.producto_id
                                    ORDER BY v.fecha DESC
                                    LIMIT 5
                                ')->fetchAll();

                                foreach ($ventas_recientes as $venta): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($venta['cliente']) ?></td>
                                        <td><?= htmlspecialchars($venta['producto']) ?></td>
                                        <td><?= htmlspecialchars($venta['cantidad']) ?> kg</td>
                                        <td>S/ <?= number_format($venta['total'], 2) ?></td>
                                        <td><?= date('Y-m-d', strtotime($venta['fecha'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-minimal">
                <div class="card-body">
                    <h5 class="card-title mb-3">Productos más vendidos</h5>
                    <?php
                    $productos_top = $pdo->query('
                        SELECT 
                            p.nombre,
                            SUM(v.cantidad) as total_vendido,
                            (SUM(v.cantidad) * 100.0 / (SELECT SUM(cantidad) FROM ventas)) as porcentaje
                        FROM ventas v
                        JOIN productos p ON p.id = v.producto_id
                        GROUP BY p.id, p.nombre
                        ORDER BY total_vendido DESC
                        LIMIT 3
                    ')->fetchAll();

                    foreach ($productos_top as $producto): ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($producto['nombre']) ?></h6>
                                <small class="text-muted"><?= number_format($producto['total_vendido']) ?> kg vendidos</small>
                            </div>
                            <span class="badge badge-soft"><?= number_format($producto['porcentaje'], 1) ?>%</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

} catch (PDOException $e) {
    // En caso de error en la base de datos, mostrar un mensaje amigable
    $content = '<div class="container mt-4">
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Hubo un problema al cargar los datos del dashboard. Por favor, inténtelo de nuevo más tarde.
        </div>
    </div>';
}

include __DIR__ . '/layout.php';