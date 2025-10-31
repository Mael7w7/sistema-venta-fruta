<?php
require __DIR__ . '/_auth.php';
require __DIR__ . '/../config/db.php';

$pdo = (new Database())->getConnection();

// Create or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    if ($nombre !== '') {
        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE clientes SET nombre=?, email=?, telefono=? WHERE id=?');
            $stmt->execute([$nombre, $email, $telefono, $id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO clientes (nombre, email, telefono) VALUES (?,?,?)');
            $stmt->execute([$nombre, $email, $telefono]);
        }
    }
    header('Location: /admin/clientes.php');
    exit;
}

// Delete
if (($_GET['action'] ?? '') === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) {
        $pdo->prepare('DELETE FROM clientes WHERE id=?')->execute([$id]);
    }
    header('Location: /admin/clientes.php');
    exit;
}

// Paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10; // 10 filas por página
$offset = ($page - 1) * $per_page;

// Consulta para obtener el total de registros
$total_rows = $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn();
$total_pages = ceil($total_rows / $per_page);

// Consulta paginada
$clientes = $pdo->query("SELECT * FROM clientes ORDER BY id DESC LIMIT $per_page OFFSET $offset")->fetchAll();

ob_start();
?>
<div class="container">
    <div class="page-header">
        <h3 class="page-title"><i class="bi bi-people text-primary"></i> Clientes</h3>
        <button class="btn btn-primary" id="btnNuevoCliente"><i class="bi bi-plus"></i> Nuevo</button>
    </div>

    <div class="card card-minimal">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $c): ?>
                        <tr>
                            <td><span class="badge badge-soft">#<?= $c['id'] ?></span></td>
                            <td><?= htmlspecialchars($c['nombre']) ?></td>
                            <td><?= htmlspecialchars($c['email']) ?></td>
                            <td><?= htmlspecialchars($c['telefono']) ?></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-secondary" onclick="openEdit(<?= $c['id'] ?>,'<?= htmlspecialchars($c['nombre'], ENT_QUOTES) ?>','<?= htmlspecialchars($c['email'], ENT_QUOTES) ?>','<?= htmlspecialchars($c['telefono'], ENT_QUOTES) ?>')"><i class="bi bi-pencil"></i></button>
                                <a class="btn btn-sm btn-outline-danger" href="?action=delete&id=<?= $c['id'] ?>" onclick="return confirm('¿Eliminar cliente?')"><i class="bi bi-trash"></i></a>
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
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar el modal correctamente
  const modalEl = document.getElementById('clienteModal');
  const clienteModal = new bootstrap.Modal(modalEl);
  
  // Botón para nuevo cliente
  document.getElementById('btnNuevoCliente').addEventListener('click', function() {
    document.getElementById('clienteForm').reset();
    document.getElementById('id').value = '';
    clienteModal.show();
  });
  
  // Función para editar cliente
  window.openEdit = function(id, nombre, email, telefono) {
    document.getElementById('id').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('email').value = email;
    document.getElementById('telefono').value = telefono;
    clienteModal.show();
  };
});
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
