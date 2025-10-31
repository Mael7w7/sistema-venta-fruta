<?php
require __DIR__ . '/_auth.php';
require __DIR__ . '/../config/db.php';
$pdo = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    if ($nombre !== '') {
        if ($id > 0) {
            $pdo->prepare('UPDATE productos SET nombre=?, precio=? WHERE id=?')->execute([$nombre, $precio, $id]);
        } else {
            $pdo->prepare('INSERT INTO productos (nombre, precio) VALUES (?,?)')->execute([$nombre, $precio]);
        }
    }
    header('Location: /admin/productos.php');
    exit;
}

if (($_GET['action'] ?? '') === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) $pdo->prepare('DELETE FROM productos WHERE id=?')->execute([$id]);
    header('Location: /admin/productos.php');
    exit;
}

// Paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10; // 10 filas por página
$offset = ($page - 1) * $per_page;

// Consulta para obtener el total de registros
$total_rows = $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
$total_pages = ceil($total_rows / $per_page);

// Consulta paginada
$items = $pdo->query("SELECT * FROM productos ORDER BY id DESC LIMIT $per_page OFFSET $offset")->fetchAll();

ob_start();
?>
<div class="container">
    <div class="page-header">
        <h3 class="page-title"><i class="bi bi-box-seam text-primary"></i> Productos</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productoModal"><i class="bi bi-plus"></i> Nuevo</button>
    </div>

    <div class="card card-minimal">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                        <tr>
                            <td><span class="badge badge-soft">#<?= $it['id'] ?></span></td>
                            <td><?= htmlspecialchars($it['nombre']) ?></td>
                            <td>S/ <?= number_format($it['precio'], 2) ?></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-secondary" onclick="openEdit(<?= $it['id'] ?>,'<?= htmlspecialchars($it['nombre'], ENT_QUOTES) ?>', <?= number_format($it['precio'], 2, '.', '') ?>)"><i class="bi bi-pencil"></i></button>
                                <a class="btn btn-sm btn-outline-danger" href="?action=delete&id=<?= $it['id'] ?>" onclick="return confirm('¿Eliminar producto?')"><i class="bi bi-trash"></i></a>
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



<script>
let productoModal;
document.addEventListener('DOMContentLoaded', ()=>{
  const el = document.getElementById('productoModal');
  productoModal = new bootstrap.Modal(el);
  
  // Asegurarse de que el botón "Nuevo" funcione correctamente
  document.querySelector('button[data-bs-toggle="modal"][data-bs-target="#productoModal"]').addEventListener('click', function() {
    // Limpiar el formulario al abrir el modal para nuevo producto
    document.getElementById('producto_id').value = '';
    document.getElementById('producto_nombre').value = '';
    document.getElementById('producto_precio').value = '';
    productoModal.show();
  });
});

function openEdit(id, nombre, precio){
  document.getElementById('producto_id').value = id;
  document.getElementById('producto_nombre').value = nombre;
  document.getElementById('producto_precio').value = precio;
  productoModal.show();
}
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
