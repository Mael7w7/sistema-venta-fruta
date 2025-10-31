<?php
require __DIR__ . '/_auth.php';
require __DIR__ . '/../config/db.php';
$pdo = (new Database())->getConnection();

$clientes = $pdo->query('SELECT id, nombre FROM clientes ORDER BY nombre')->fetchAll();
$productos = $pdo->query('SELECT id, nombre, precio FROM productos ORDER BY nombre')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $cliente_id = intval($_POST['cliente_id'] ?? 0);
    $producto_id = intval($_POST['producto_id'] ?? 0);
    $cantidad = intval($_POST['cantidad'] ?? 1);
    $fecha = $_POST['fecha'] ?: date('Y-m-d');
    if ($cliente_id && $producto_id && $cantidad > 0) {
        if ($id > 0) {
            $pdo->prepare('UPDATE ventas SET cliente_id=?, producto_id=?, cantidad=?, fecha=? WHERE id=?')->execute([$cliente_id, $producto_id, $cantidad, $fecha, $id]);
        } else {
            $pdo->prepare('INSERT INTO ventas (cliente_id, producto_id, cantidad, fecha) VALUES (?,?,?,?)')->execute([$cliente_id, $producto_id, $cantidad, $fecha]);
        }
    }
    header('Location: /admin/ventas.php');
    exit;
}

if (($_GET['action'] ?? '') === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) $pdo->prepare('DELETE FROM ventas WHERE id=?')->execute([$id]);
    header('Location: /admin/ventas.php');
    exit;
}

// Paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10; // 10 filas por página
$offset = ($page - 1) * $per_page;

// Consulta para obtener el total de registros
$total_rows = $pdo->query('SELECT COUNT(*) FROM ventas')->fetchColumn();
$total_pages = ceil($total_rows / $per_page);

// Consulta paginada
$rows = $pdo->query("SELECT v.id, c.nombre AS cliente, p.nombre AS producto, p.precio, v.cantidad, v.fecha, (p.precio*v.cantidad) total
FROM ventas v
JOIN clientes c ON c.id=v.cliente_id
JOIN productos p ON p.id=v.producto_id
ORDER BY v.id DESC
LIMIT $per_page OFFSET $offset")->fetchAll();

ob_start();
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title"><i class="bi bi-receipt"></i> Ventas</h3>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ventaModal"><i class="bi bi-plus"></i> Nueva</button>
    </div>

    <div class="card card-minimal">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark">#<?= $r['id'] ?></span></td>
                            <td><?= htmlspecialchars($r['cliente']) ?></td>
                            <td><?= htmlspecialchars($r['producto']) ?></td>
                            <td><?= $r['cantidad'] ?></td>
                            <td><?= htmlspecialchars($r['fecha']) ?></td>
                            <td>S/ <?= number_format($r['total'], 2) ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-danger" href="?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('¿Eliminar venta?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Controles de paginación -->
        <?php if ($total_pages > 1): ?>
        <div class="card-footer">
            <nav aria-label="Navegación de páginas">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- El modal de ventas ahora se carga desde modals.php -->
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
